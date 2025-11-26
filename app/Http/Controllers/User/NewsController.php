<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class NewsController extends Controller
{
    public function news_info(Announcement $announcement)
    {
        return view('user.news.news_info', compact('announcement'));
    }


    // ニュース一覧
    public function newsListAll(Request $request)
    {
        $category = $request->query('category', 'all'); // デフォルト all

        $query = Announcement::where('status', 2) // 承認済み
            ->where('is_show', 1);               // 表示対象のみ

        // course_id による絞り込み
        if ($category === 'main') {
            $query->where('course_id', '>=', 1); // 訓練校の course_id
        } elseif ($category === 'websys') {
            $query->where('course_id', NULL); // 本講座の course_id
        }

        $announcements = $query->orderBy('created_at', 'desc')->get();

        return view('user.news.news_list', compact('announcements', 'category'));
    }
}
