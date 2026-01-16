<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learning;

class LearningController extends Controller
{
    // 全件一覧
    public function index()
    {
        $learnings = Learning::where('is_show', 1)->orderBy('id', 'asc')->get();
        $breadcrumbTitle = '学習リソース';

        return view('user.learnings.learnings_list', compact('learnings', 'breadcrumbTitle'));
    }

    // タイプ別一覧
    public function byType($type)
    {
        $learnings = Learning::where('is_show', 1)
            ->where('type', $type)
            ->orderBy('id', 'asc')
            ->get();

        $breadcrumbTitle = match ((int)$type) {
            1 => '参考書籍',
            2 => '参考サイト',
            3 => 'IT資格',
            4 => '製作品',
            default => '学習リソース',
        };

        return view('user.learnings.learnings_by_type', compact('learnings', 'type', 'breadcrumbTitle'));
    }

    // 詳細
    public function show(Learning $learning, Request $request)
    {
        $type = $request->query('type');

        $prevLearning = Learning::where('is_show', 1)
            ->when($type, fn($q) => $q->where('type', $type))
            ->where('id', '<', $learning->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextLearning = Learning::where('is_show', 1)
            ->when($type, fn($q) => $q->where('type', $type))
            ->where('id', '>', $learning->id)
            ->orderBy('id', 'asc')
            ->first();

        $breadcrumbTitle = match ((int)$type) {
            1 => '参考書籍',
            2 => '参考サイト',
            3 => 'IT資格',
            4 => '製作品',
            default => '学習リソース',
        };

        return view('user.learnings.learnings_info', compact(
            'learning',
            'type',
            'prevLearning',
            'nextLearning',
            'breadcrumbTitle'
        ));
    }
}
