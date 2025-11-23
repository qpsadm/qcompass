<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agenda;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * アジェンダ一覧
     */
    public function index(Request $request)
    {
        // 検索対応（例：名前検索）
        $query = Agenda::query();

        if ($search = $request->input('search')) {
            $query->where('agenda_name', 'like', "%{$search}%");
        }

        $agendas = $query->orderBy('id', 'desc')->paginate(10); // paginate に変更

        return view('admin.agendas.index', compact('agendas'));
    }
    /**
     * 作成画面
     */
    public function create()
    {
        $rootCategories = Category::with('children')
            ->whereNull('parent_id')
            ->where('code', '!=', 'notice')
            ->get();

        $agenda = new Agenda();
        $categories = $this->buildCategoryOptions($rootCategories);

        return view('admin.agendas.create', compact('categories', 'agenda'));
    }

    /**
     * 保存
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'is_show' => 'nullable|boolean',
            'status' => 'required|in:yes,no',
            'content' => 'nullable|string',
        ]);

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['user_id'] = auth()->id();
        $validated['created_user_name'] = auth()->user()->name ?? 'system';

        Agenda::create($validated);

        return redirect()->route('admin.agendas.index')
            ->with('success', 'アジェンダを作成しました');
    }

    /**
     * 編集画面
     */
    public function edit(Agenda $agenda)
    {

        $selectedCourses = $agenda->courses->pluck('id')->toArray();

        $rootCategories = Category::with('children')
            ->whereNull('parent_id')
            ->where('code', '!=', 'notice')
            ->get();

        $categories = $this->buildCategoryOptions($rootCategories);

        return view('admin.agendas.edit', compact('agenda', 'selectedCourses', 'categories'));
    }

    /**
     * 更新
     */
    public function update(Request $request, Agenda $agenda)
    {
        // バリデーションに description を追加
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'nullable|integer',
            'is_show' => 'nullable|boolean',
            'status' => 'required|in:yes,no',
            'content' => 'nullable|string',
        ]);

        $validated['is_show'] = $request->has('is_show') ? 1 : 0;
        $validated['updated_user_name'] = auth()->user()->name;

        $agenda->update($validated);

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを更新しました');
    }


    /**
     * 削除
     */
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを削除しました。');
    }
    /**
     * アジェンダ詳細
     */
    public function show(Agenda $agenda)
    {
        return view('admin.agendas.show', compact('agenda'));
    }
    /**
     * 論理削除済み一覧
     */
    public function trash()
    {
        $agendas = Agenda::onlyTrashed()->get();
        return view('admin.agendas.trash', compact('agendas'));
    }

    /**
     * 論理削除から復元
     */
    public function restore($id)
    {
        $agenda = Agenda::onlyTrashed()->findOrFail($id);
        $agenda->restore();

        return redirect()->route('admin.agendas.trash')->with('success', 'アジェンダを復元しました。');
    }

    /**
     * カテゴリツリーを配列に変換
     */
    private function buildCategoryOptions($categories, $prefix = '')
    {
        $options = [];
        foreach ($categories as $category) {
            $options[] = [
                'id' => $category->id,
                'name' => $prefix . $category->name,
            ];

            if ($category->children->isNotEmpty()) {
                $options = array_merge($options, $this->buildCategoryOptions($category->children, $prefix . '— '));
            }
        }
        return $options;
    }
    // app/Http/Controllers/Admin/AgendaController.php

    public function preview($agendaId)
    {
        // Agenda を取得、Category もロード
        $agenda = Agenda::with('category')->find($agendaId);

        if (!$agenda) {
            abort(404, 'アジェンダが存在しません。');
        }

        $category = $agenda->category;

        if (!$category) {
            abort(404, 'アジェンダに関連するカテゴリが存在しません。');
        }

        $course = $category->course ?? null;

        if (!$course) {
            abort(404, 'このアジェンダに関連するコースが存在しません。');
        }

        // categories と agendas をコース単位でまとめる
        $categories = $course->categories()->with('agendas')->get();

        return view('admin.agendas.preview', compact('course', 'categories'));
    }
}
