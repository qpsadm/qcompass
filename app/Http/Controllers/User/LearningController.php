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

    // タイプ別一覧（タグ絞り込み対応）
    public function byType($type)
    {
        $typeMap = [
            1 => 'book',
            2 => 'site',
            3 => 'video',
            4 => 'article', // 製作品
            5 => 'other',
        ];

        $typeId = (int)$type;
        if (!isset($typeMap[$typeId])) abort(404);

        $typeString = $typeMap[$typeId];
        $currentTag = request('tag', 'all');

        // 総件数（タグ絞り込み前）
        $allCount = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->count();

        // タグ件数（タグごとの件数）
        $tagCounts = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->select('tag_id', DB::raw('count(*) as count'))
            ->groupBy('tag_id')
            ->pluck('count', 'tag_id');

        // 学習コンテンツ取得（タグ絞り込み） ← paginate に変更
        $learnings = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->when($currentTag !== 'all', function ($q) use ($currentTag) {
                $q->where('tag_id', $currentTag);
            })
            ->orderBy('id', 'asc')
            ->paginate(5)        // ページネーション10件ずつ
            ->withQueryString();   // ?tag=3 などを維持

        // Breadcrumb 用タイトル
        $breadcrumbTitle = match ($typeId) {
            1 => '参考書籍',
            2 => '参考サイト',
            3 => 'IT資格',
            4 => '製作品',
            5 => 'その他',
            default => '学習リソース',
        };

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
        $typeId = (int) $request->query('type');

        $typeMap = [
            1 => 'book',
            2 => 'site',
            3 => 'video',
            4 => 'article',
            5 => 'other',
        ];

        $typeString = $typeMap[$typeId] ?? null;

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
            4 => '製作品',
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
}
