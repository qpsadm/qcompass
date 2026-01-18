<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;
use Illuminate\Support\Facades\DB;

class LearningController extends Controller
{
    // 全件一覧
    public function index()
    {
        $learnings = Learning::where('is_show', 1)
            ->orderBy('id', 'asc')
            ->paginate(5)       // ページネーション対応
            ->withQueryString();  // クエリ保持

        $breadcrumbTitle = '学習リソース';

        return view('user.learnings.learnings_list', compact('learnings', 'breadcrumbTitle'));
    }

    // タイプ別一覧
    public function byType($typeId)
    {
        $typeId = (int) $typeId;

        $typeMap = [
            1 => 'book',
            2 => 'site',
            3 => 'video',
            4 => 'article',
            5 => 'other',
        ];

        if (!isset($typeMap[$typeId])) abort(404);

        $typeString = $typeMap[$typeId];
        $currentTag = request('tag', 'all');

        $allCount = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->count();

        $tagCounts = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->select('tag_id', DB::raw('count(*) as count'))
            ->groupBy('tag_id')
            ->pluck('count', 'tag_id');

        $learnings = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->when($currentTag !== 'all', fn($q) => $q->where('tag_id', $currentTag))
            ->orderBy('id', 'asc')
            ->paginate(5)
            ->withQueryString();

        $breadcrumbTitle = match ($typeId) {
            1 => '参考書籍',
            2 => '参考サイト',
            3 => 'IT資格',
            4 => '制作品',
            5 => 'その他',
            default => '学習リソース',
        };

        // ここで typeId が 4 のときだけ別ビューを返す
        if ($typeId === 4) {
            return view('user.learnings.learnings_list', compact(
                'learnings',
                'typeId',
                'breadcrumbTitle',
                'tagCounts',
                'currentTag',
                'allCount'
            ));
        }

        // 通常ビュー
        return view('user.learnings.learnings_by_type', compact(
            'learnings',
            'typeId',
            'breadcrumbTitle',
            'tagCounts',
            'currentTag',
            'allCount'
        ));
    }


    // 詳細ページ
    public function show(Learning $learning, Request $request)
    {
        $typeId = (int) $request->query('type') ?: null;

        $typeMap = [
            1 => 'book',
            2 => 'site',
            3 => 'video',
            4 => 'article',
            5 => 'other',
        ];

        $typeString = $typeId ? ($typeMap[$typeId] ?? null) : null;

        $prevLearning = Learning::where('is_show', 1)
            ->when($typeString, fn($q) => $q->where('type', $typeString))
            ->where('id', '<', $learning->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextLearning = Learning::where('is_show', 1)
            ->when($typeString, fn($q) => $q->where('type', $typeString))
            ->where('id', '>', $learning->id)
            ->orderBy('id', 'asc')
            ->first();

        $breadcrumbTitle = match ($typeId) {
            1 => '参考書籍',
            2 => '参考サイト',
            3 => 'IT資格',
            4 => '制作品',
            5 => 'その他',
            default => '学習リソース',
        };

        return view('user.learnings.learnings_info', compact(
            'learning',
            'typeId',
            'prevLearning',
            'nextLearning',
            'breadcrumbTitle'
        ));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|string|in:book,site,video,article,other',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'url'         => 'nullable|url|max:255',
            'level'       => 'required|string|in:初級,上級', // ← ここを必須に
            'tag_id'      => 'required|integer|exists:tags,id', // タグも必須にしたい場合
            'is_show'     => 'required|boolean',
        ]);


        // 空文字・nullを未設定に変換
        $level = !empty($validated['level']) ? $validated['level'] : '未設定';

        // 画像：アップロードがあれば優先、なければURL、それもなければ null
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')->store('learnings', 'public');
        } elseif (!empty($validated['image'])) {
            $imagePath = $validated['image'];
        } else {
            $imagePath = null;
        }

        Learning::create([
            'type'        => $validated['type'],
            'title'       => $validated['title'],
            'description' => $validated['description'] ?? null,
            'image'       => $imagePath,
            'url'         => $validated['url'] ?? null,
            'level'       => $level,
            'tag_id'      => $validated['tag_id'],
            'is_show'     => $validated['is_show'],
        ]);

        return redirect()->route('admin.learnings.index')
            ->with('success', 'Learning作成完了');
    }
}
