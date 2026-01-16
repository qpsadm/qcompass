<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Learning;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    /**
     * 一覧表示
     */
    public function index(Request $request, $type = null)
    {
        $query = Learning::with('tag')->where('is_show', true);

        // タイプごとの絞り込み
        if ($type) {
            $query->where('type', $type);
        }

        // タグで絞り込む場合
        if ($request->filled('tag_id')) {
            $query->where('tag_id', $request->tag_id);
        }

        $learnings = $query->orderBy('title', 'asc')
            ->paginate(20)
            ->withQueryString();

        return view('user.learnings.learnings_list', compact('learnings', 'type'));
    }

    /**
     * 詳細表示
     */
    public function show(Learning $learning, Request $request)
    {
        if (!$learning->is_show) {
            abort(404);
        }

        // 前後の学習リソースを取得（任意）
        $prevLearning = Learning::where('id', '<', $learning->id)
            ->where('is_show', true)
            ->orderBy('id', 'desc')
            ->first();

        $nextLearning = Learning::where('id', '>', $learning->id)
            ->where('is_show', true)
            ->orderBy('id', 'asc')
            ->first();

        // クエリパラメータ type を取得
        $type = $request->query('type');

        return view('user.learnings.learnings_info', compact('learning', 'prevLearning', 'nextLearning', 'type'));
    }

    /**
     * タイプ別一覧
     */
    public function byType(Request $request, $type)
    {
        $typeNames = [
            1 => '参考書籍',
            2 => '参考サイト',
            3 => 'IT資格',
            4 => '製作品',
        ];

        $learnings = Learning::with('tag')
            ->where('type', $type)
            ->where('is_show', true)
            ->orderBy('title')
            ->paginate(20)
            ->withQueryString();

        $typeName = $typeNames[$type] ?? '不明';

        return view('user.learnings.learnings_by_type', compact('learnings', 'typeName', 'type'));
    }
}
