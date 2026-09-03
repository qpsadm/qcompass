<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agenda;
use App\Models\Course;
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
        $query = Agenda::with('category');

        // 検索
        if ($search = $request->search) {
            $query->where('agenda_name', 'like', "%{$search}%");
        }

        // カテゴリー絞り込み
        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }

        // ステータス絞り込み
        if ($status = $request->status) {
            if ($status === 'yes') $query->where('status', 'yes');
            else $query->where('status', 'draft');
        }

        // 並び替え用
        // $sort = $request->sort ?? null;
        $sort = $request->get('sort', 'updated_at');          // デフォルト No.(id)
        $direction = $request->direction ?? 'desc';

        // ソート可能カラム
        $allowedSort = ['agenda_name', 'status', 'created_user_name', 'created_at', 'updated_at', 'id', 'category_id'];

        if ($sort && in_array($sort, $allowedSort)) {
            $query->orderBy($sort, $direction)->orderBy('id', 'desc');
        } else {
            // デフォルト：更新日降順 → カテゴリー順 → ID降順
            $categoryOrder = Category::pluck('id')->toArray();
            if (!empty($categoryOrder)) {
                $orderSql = "CASE category_id ";
                foreach ($categoryOrder as $index => $catId) {
                    $orderSql .= "WHEN {$catId} THEN {$index} ";
                }
                $orderSql .= "END";

                $query->orderBy('updated_at', 'desc')
                    ->orderByRaw($orderSql)
                    ->orderBy('id', 'desc');
            } else {
                $query->orderBy('updated_at', 'desc')->orderBy('id', 'desc');
            }
        }

        $agendas = $query->paginate(10)
            ->onEachSide(1);         //左にあるページネーションのボタン数を減らす;

        // プルダウン用
        $categories = Category::where('is_show', 1)
            ->orderBy('id', 'desc')->get();


        return view('admin.agendas.index', compact('agendas', 'categories', 'sort', 'direction'));
    }


    /**
     * 講座ごとのアジェンダ一覧
     */
    public function indexByCourse(Course $course)
    {
        $course->load(['categories' => function ($q) {
            $q->whereNull('categories.deleted_at') // ← テーブル名を明示
                ->orderBy('categories.id', 'asc') // 👈 category ID の昇順を追加
                ->with(['agendas' => function ($q2) {
                    $q2->whereNull('deleted_at')   // agendasテーブルだけなのでOK
                        ->orderBy('id', 'asc');
                }]);
        }]);

        return view('admin.course_category.agendas', compact('course'));
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
        $agenda->load('files');

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
            'category_id' => 'required|integer',
            'is_show' => 'nullable|in:0,1',
            'status' => 'required|in:yes,draft',
            'content' => 'nullable|string',
        ]);

        $validated['is_show'] = $request->input('is_show', 0);
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
        $agenda->load(['files' => function ($q) {
            $q->withTrashed();
        }]);

        $rootCategories = Category::with('children')
            ->whereNull('parent_id')
            ->where('code', '!=', 'notice')
            ->get();

        $categories = $this->buildCategoryOptions($rootCategories);

        return view('admin.agendas.edit', compact('agenda', 'categories'));
    }

    /**
     * 更新
     */
    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'agenda_name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'is_show' => 'nullable|in:0,1',
            'status' => 'required|in:yes,draft',
            'content' => 'nullable|string',
        ]);

        $validated['is_show'] = $request->input('is_show', 0);
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

        $agenda->courses()->detach();
        $agenda->delete();

        return redirect()->route('admin.agendas.index')->with('success', 'アジェンダを削除しました（論理削除）');
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
        $agendas = Agenda::onlyTrashed()->paginate(20);
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

    public function preview($agendaId)
    {
        $agenda = Agenda::with('category.courses')->find($agendaId);

        if (!$agenda) {
            abort(404, '指定されたアジェンダは存在しません。');
        }

        $category = $agenda->category;
        if (!$category) {
            abort(404, 'このアジェンダに関連するカテゴリが存在しません。');
        }

        // $course = $category->courses->first();
        // if (!$course) {
        //     abort(404, 'このカテゴリに関連するコースが存在しません。');
        // }

        // コースの取得（優先度1: アジェンダ直接のコース / 優先度2: カテゴリ経由のコース）
        $course = $agenda->courses->first()
            ?? $category?->courses?->first();

        return view('admin.agendas.preview', compact('agenda', 'category', 'course'));
    }

    public function files(?Agenda $agenda = null)
    {
        $files = $agenda ? $agenda->files : \App\Models\AgendaFile::latest()->get();
        return view('admin.agendas.files', compact('agenda', 'files'));
    }
}
