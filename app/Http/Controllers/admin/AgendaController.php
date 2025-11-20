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
    public function index()
    {
        $noticeCategoryId = Category::where('code', 'notice')->value('id');

        $agendas = Agenda::with(['category', 'createdUser', 'courses'])
            ->whereNull('deleted_at')
            ->where('category_id', '!=', $noticeCategoryId)
            ->get();

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
        $validated['created_user_name'] = auth()->user()->name;

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
}
