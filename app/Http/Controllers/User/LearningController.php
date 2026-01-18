<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;
use Illuminate\Support\Facades\DB;

class LearningController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 全件一覧（検索対応）
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');

        $learnings = Learning::where('is_show', 1)
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(5)
            ->withQueryString();

        $breadcrumbTitle = '学習リソース';

        return view('user.learnings.learnings_list', compact(
            'learnings',
            'breadcrumbTitle',
            'keyword'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | タイプ別一覧（検索 + タグ対応）
    |--------------------------------------------------------------------------
    */
    public function byType(Request $request, $typeId)
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
        $currentTag = $request->query('tag', 'all');
        $keyword    = $request->query('keyword');

        $baseQuery = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->when($currentTag !== 'all', fn($q) => $q->where('tag_id', $currentTag))
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%");
                });
            });

        $learnings = (clone $baseQuery)
            ->orderBy('id', 'asc')
            ->paginate(5)
            ->withQueryString();

        $allCount = (clone $baseQuery)->count();

        $tagCounts = Learning::where('is_show', 1)
            ->where('type', $typeString)
            ->select('tag_id', DB::raw('count(*) as count'))
            ->groupBy('tag_id')
            ->pluck('count', 'tag_id');

        $breadcrumbTitle = match ($typeId) {
            1 => '参考書籍',
            2 => '参考サイト',
            3 => 'IT資格',
            4 => '制作品',
            5 => 'その他',
            default => '学習リソース',
        };

        // type=4（制作品）は list ビュー
        if ($typeId === 4) {
            return view('user.learnings.learnings_list', compact(
                'learnings',
                'typeId',
                'breadcrumbTitle',
                'tagCounts',
                'currentTag',
                'allCount',
                'keyword'
            ));
        }

        return view('user.learnings.learnings_by_type', compact(
            'learnings',
            'typeId',
            'breadcrumbTitle',
            'tagCounts',
            'currentTag',
            'allCount',
            'keyword'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | 詳細ページ
    |--------------------------------------------------------------------------
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
}
