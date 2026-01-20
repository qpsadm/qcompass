<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;

class LearningController extends Controller
{
    /**
     * 一覧表示
     */
    /**
     * 一覧表示（検索・絞り込み・ソート対応）
     */
    public function index(Request $request)
    {
        $query = Learning::with('tag');

        // --- 絞り込み ---
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('tag_id')) {
            $query->where('tag_id', $request->tag_id);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('is_visible')) {
            $query->where('is_show', $request->is_visible);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // --- ソート ---
        $sortable = ['id', 'title', 'level', 'type'];
        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');

        if (!in_array($sort, $sortable)) {
            $sort = 'id';
        }

        $query->orderBy($sort, $direction);

        $learnings = $query
            ->paginate(15)
            ->withQueryString();

        return view('admin.learnings.index', compact('learnings'));
    }


    /**
     * 作成フォーム
     */
    public function create()
    {
        $tags = Tag::all();
        return view('admin.learnings.create', compact('tags'));
    }

    /**
     * 新規作成処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:book,site,video,article,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|file|image|max:10240',
            'url' => 'nullable|url|max:255',
            'level' => 'required|integer',
            'is_show' => 'nullable|boolean',
            'tag_id' => 'nullable|exists:tags,id',
            'course_name' => 'nullable|string|max:255',
            'priod' => 'nullable|string|max:255',
        ]);

        // ファイルアップロード処理（store と update 共通）
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            // 元のファイル名取得
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();

            // 日本語や空白を半角アンダースコアに置換
            $safeName = preg_replace('/[^\w\-]/u', '_', $originalName);

            // 日付＋安全なファイル名＋拡張子
            $fileName = date('Ymd_His') . '_' . $safeName . '.' . $extension;

            // public/storage/learnings に保存
            $path = $file->storeAs('learnings', $fileName, 'public');

            $validated['image'] = $path;
        }


        $validated['is_show'] = $request->boolean('is_show');

        Learning::create($validated);

        return redirect()->route('admin.learnings.index')->with('success', 'Learning作成完了');
    }

    /**
     * 詳細表示
     */
    public function show($id)
    {
        $learning = Learning::with('tag')->findOrFail($id);
        return view('admin.learnings.show', compact('learning'));
    }

    /**
     * 編集フォーム
     */
    public function edit($id)
    {
        $learning = Learning::findOrFail($id);
        $tags = Tag::all();
        return view('admin.learnings.edit', compact('learning', 'tags'));
    }

    /**
     * 更新処理
     */
    public function update(Request $request, $id)
    {
        $learning = Learning::findOrFail($id);

        // バリデーション
        $validated = $request->validate([
            'type' => 'required|in:book,site,video,article,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|file|image|max:10240',
            'url' => 'nullable|url|max:255',
            'level' => 'nullable|integer|min:1|max:5',
            'is_show' => 'nullable|boolean',
            'tag_id' => 'nullable|exists:tags,id',
            'course_name' => 'nullable|string|max:255',
            'priod' => 'nullable|string|max:255',
            'delete_image' => 'nullable|boolean',
        ]);

        // description は空送信でも元値を保持
        $validated['description'] = $request->input('description', $learning->description);
        $validated['is_show'] = $request->boolean('is_show');

        // 画像削除
        if ($request->boolean('delete_image') && $learning->image) {
            Storage::disk('public')->delete($learning->image);
            $validated['image'] = null;
        }

        // 新しい画像アップロード
        if ($request->hasFile('image_file')) {
            if ($learning->image) {
                Storage::disk('public')->delete($learning->image);
            }
            $file = $request->file('image_file');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $safeName = preg_replace('/[^\w\-]/u', '_', $originalName);
            $fileName = date('Ymd_His') . '_' . $safeName . '.' . $extension;
            $validated['image'] = $file->storeAs('learnings', $fileName, 'public');
        }

        // deleted_at を絶対に触らない
        $learning->update($validated);

        return redirect()->route('admin.learnings.show', $learning->id)
            ->with('success', 'Learning更新完了');
    }



    /**
     * 削除処理
     */
    public function destroy($id)
    {
        $learning = Learning::findOrFail($id);

        // 画像ファイルがあれば削除
        if ($learning->image) {
            Storage::disk('public')->delete($learning->image);
        }

        // 必要であれば他のアップロードファイルも同様に削除
        // if ($learning->plan_path) { Storage::disk('public')->delete($learning->plan_path); }
        // if ($learning->flier_path) { Storage::disk('public')->delete($learning->flier_path); }

        // DBレコード削除
        $learning->delete();

        return redirect()->route('admin.learnings.index')->with('success', 'Learning削除完了');
    }
}
