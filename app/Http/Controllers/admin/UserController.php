<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Course;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * ユーザー一覧
     */
    public function index(Request $request)
    {
        $search     = $request->input('search');
        $courseId   = $request->input('course_id');   // 講座IDフィルタ
        $unassigned = $request->input('unassigned');  // 未所属フラグ
        $sort       = $request->input('sort', 'id');
        $order      = $request->input('order', 'asc');

        $users = User::query()
            ->with(['role', 'courses']);

        // 🔍 検索
        if ($search) {
            $users->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // 🎓 講座絞り込み
        if ($courseId) {
            $users->whereHas('courses', function ($q) use ($courseId) {
                $q->where('courses.id', $courseId);
            });
        }

        // ❌ 未所属のみ
        if ($unassigned === '1') {
            $users->doesntHave('courses');
        }

        // 🔽 並び替え
        if (in_array($sort, ['id', 'code', 'name'])) {
            $users->orderBy($sort, $order);
        }

        $users = $users->paginate(20)->appends($request->query());

        // プルダウン用講座一覧
        $courses = Course::orderBy('course_name')->get();

        return view('admin.users.index', compact('users', 'courses'));
    }


    /**
     * ユーザー作成画面
     */
    public function create()
    {
        $roles = Role::all();
        $courses = Course::all();
        $divisions = Division::all();   // ← 追加
        return view('admin.users.create', compact('roles', 'courses', 'divisions'));
    }

    /**
     * ユーザー登録
     */
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'code' => 'required|string|max:250|unique:users,code', // ← 追加
            'name' => 'required|string|max:250',
            'furigana' => 'required|string|max:250',
            'roman_name' => 'required|string|max:250',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'division_id' => 'nullable|integer',
            'email' => 'nullable|email|unique:users,email',
        ]);

        // パスワードをハッシュ化
        $validated['password'] = Hash::make($validated['password']);

        // 作成者名をセット
        $validated['created_user_name'] = auth()->user()->name ?? 'system';

        // 表示フラグを初期値でセット
        $validated['is_show'] = true;

        // ユーザー作成
        $user = User::create($validated);

        // 中間テーブルに登録
        if (!empty($request->courses_id)) {
            $user->courses()->sync(
                collect($request->courses_id)->mapWithKeys(fn($id) => [$id => ['created_user_name' => auth()->user()->name]])->toArray()

            );
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'ユーザー作成完了');
    }


    /**
     * ユーザー編集画面
     */
    public function edit(User $user)
    {
        $roles = Role::all();      // これがないと空になります
        $courses = Course::all();  // 講座も同様
        // division マスタ
        $divisions = Division::where('is_show', 1)->get();

        return view('admin.users.edit', compact('user', 'roles', 'courses', 'divisions'));
    }

    /**
     * ユーザー更新
     */
    public function update(Request $request, User $user)
    {
        // バリデーション
        $validated = $request->validate([
            'code' => 'required|string|max:250|unique:users,code,' . $user->id, // ← 追加
            'name' => 'required|string|max:250',
            'furigana' => 'nullable|string|max:250',
            'roman_name' => 'nullable|string|max:250',
            'password' => 'nullable|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'division_id' => 'nullable|integer',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        // パスワードがある場合だけハッシュ化
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        // updated_user_name は id ではなく名前にしておくと store と統一できる
        $validated['updated_user_name'] = auth()->user()->name;

        // users テーブル更新（courses_id は除外）
        $user->update($validated);

        // pivot テーブルに保存
        if (!empty($request->courses_id)) {
            $user->courses()->sync(
                collect($request->courses_id)
                    ->mapWithKeys(fn($id) => [$id => ['updated_user_name' => auth()->user()->name]])
                    ->toArray()
            );
        } else {
            $user->courses()->sync([]); // 削除する場合
        }

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'ユーザー情報を更新しました。');
    }





    /**
     * ユーザー削除
     */
    public function destroy(User $user)
    {
        $user->deleted_user_name = auth()->user()->name;
        $user->save();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'ユーザー削除完了');
    }

    public function show($id)
    {
        $user = User::with('detail')->findOrFail($id); // ユーザー詳細も取得
        return view('admin.users.show', compact('user'));
    }

    // ゴミ箱一覧
    public function trash()
    {
        $trashedUsers = User::onlyTrashed()->paginate(25);
        return view('admin.users.trash', compact('trashedUsers'));
    }

    // 復元
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.trash')->with('success', 'ユーザーを復元しました。');
    }

    // 完全削除
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('admin.users.trash')->with('success', 'ユーザーを完全削除しました。');
    }

    public function showDetail(User $user)
    {
        if ($user->detail) {
            // 詳細がある場合は編集画面にリダイレクト
            return redirect()->route('admin.users.detail.edit', $user->id);
        } else {
            // 詳細がなければ新規作成
            return redirect()->route('admin.users.detail.create', $user->id);
        }
    }
}