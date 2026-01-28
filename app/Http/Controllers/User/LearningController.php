<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;
use Illuminate\Support\Facades\DB;

class LearningController extends Controller
{
    /**
     * 全件一覧
     */
    public function index()
    {
        $learnings = Learning::where('is_show', 1)
            ->orderBy('updated_at', 'desc')
            ->paginate(5)
            ->withQueryString();

        $breadcrumbTitle = '学習リソース';

        return view('user.learnings.learnings_list', compact(
            'learnings',
            'breadcrumbTitle'
        ));
    }

    /**
     * タイプ別一覧
     */
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

        if (!isset($typeMap[$typeId])) {
            abort(404);
        }

        $typeString = $typeMap[$typeId];

        // 🔑 typeId=4 のときだけ 9件
        $perPage = ($typeId === 4) ? 9 : 5;

        $currentTag = request('tag', 'all');
        $keyword    = request('keyword');

        // 全件数
        $allCount = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->count();

        // タグ別件数
        $tagCounts = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->select('tag_id', DB::raw('count(*) as count'))
            ->groupBy('tag_id')
            ->pluck('count', 'tag_id');

        // 一覧取得
        $learnings = Learning::where('is_show', 1)
            ->where('type', $typeString)

            // 🔍 キーワード検索
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($qq) use ($keyword) {
                    $qq->where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%");
                });
            })

            // 🏷 タグ絞り込み
            ->when(
                $currentTag !== 'all',
                fn($q) =>
                $q->where('tag_id', $currentTag)
            )

            ->orderBy('updated_at', 'desc')
            ->paginate($perPage)
            ->appends([
                'tag'     => $currentTag !== 'all' ? $currentTag : null,
                'keyword' => $keyword,
            ]);

        $breadcrumbTitle = match ($typeId) {
            1 => '参考書籍',
            2 => '参考サイト',
            3 => 'IT資格',
            4 => '制作品',
            5 => 'その他',
            default => '学習リソース',
        };

        return view(
            $typeId === 4
                ? 'user.learnings.learnings_list'
                : 'user.learnings.learnings_by_type',
            compact(
                'learnings',
                'typeId',
                'breadcrumbTitle',
                'tagCounts',
                'currentTag',
                'allCount'
            )
        );
    }

    /**
     * 詳細ページ
     */
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

    /**
     * 登録処理
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type'        => 'required|string|in:book,site,video,article,other',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'url'         => 'nullable|url|max:255',
            'level'       => 'required|string|in:初級,上級',
            'tag_id'      => 'required|integer|exists:tags,id',
            'is_show'     => 'required|boolean',
        ]);

        $level = $validated['level'] ?? '未設定';

        // 画像処理
        if ($request->hasFile('image_file')) {
            $imagePath = $request->file('image_file')
                ->store('learnings', 'public');
        } else {
            $imagePath = $validated['image'] ?? null;
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

        return redirect()
            ->route('admin.learnings.index')
            ->with('success', 'Learning作成完了');
    }
}
