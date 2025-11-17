<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Agenda;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    // お知らせ一覧
    public function index()
    {
        $category = Category::where('code', 'notice')->firstOrFail();

        $agendas = Agenda::where('category_id', $category->id)
            ->with('createdUser') // 作成者情報
            ->get(); // デフォルトで deleted_at != null のものは除外

        return view('admin.notice.index', compact('category', 'agendas'));
    }


    // 作成フォーム
    public function create()
    {
        $category = Category::where('code', 'notice')->firstOrFail();
        $courses = Course::where('is_show', 1)->get(); // 表示フラグが立っている講座のみ

        return view('admin.notice.create', compact('category', 'courses'));
    }

    // 保存
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
        ]);

        if (!empty($validated['description'])) {
            $decoded = htmlspecialchars_decode(html_entity_decode($validated['description'], ENT_QUOTES | ENT_HTML5));
            $decoded = str_replace('&nbsp;', ' ', $decoded);
            $validated['description'] = $decoded;
        }

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['category_id'] = Category::where('code', 'notice')->value('id');
        $validated['user_id'] = Auth::id();
        $validated['created_user_id'] = Auth::id();

        Agenda::create($validated);

        return redirect()->route('admin.notice.index')->with('success', 'お知らせを作成しました');
    }

    // 編集フォーム
    public function edit(Agenda $notice)
    {
        $courses = Course::where('is_show', 1)->get();
        return view('admin.notice.edit', [
            'agenda' => $notice,
            'courses' => $courses,
        ]);
    }

    // 更新
    public function update(Request $request, Agenda $notice)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_show' => 'nullable|boolean',
            'accept' => 'required|in:yes,no',
        ]);

        if (!empty($validated['description'])) {
            $decoded = htmlspecialchars_decode(html_entity_decode($validated['description'], ENT_QUOTES | ENT_HTML5));
            $decoded = str_replace('&nbsp;', ' ', $decoded);
            $validated['description'] = $decoded;
        }

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['updated_user_id'] = Auth::id();

        $notice->update($validated);

        return redirect()->route('admin.notice.index')->with('success', 'お知らせを更新しました');
    }

    // 削除
    public function destroy(Agenda $notice)
    {
        // SoftDeletes が入っていれば deleted_at に自動で日時が入る
        $notice->delete();

        return redirect()->route('admin.notice.index')
            ->with('success', 'お知らせを削除しました');
    }

    // カテゴリ編集フォーム
    public function editCategory()
    {
        $category = Category::where('code', 'notice')->firstOrFail();
        return view('admin.notice.edit_category', compact('category'));
    }

    // カテゴリ更新
    public function updateCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'theme_color' => 'nullable|string|max:50',
            'is_show' => 'nullable|boolean',
        ]);

        $category = Category::where('code', 'notice')->firstOrFail();
        $validated['is_show'] = $request->has('is_show') ? 1 : 0;

        $category->update($validated);

        return redirect()->route('admin.notice.index')->with('success', 'カテゴリ設定を更新しました');
    }
}
