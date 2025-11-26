<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class NewsController extends Controller
{
    public function newsListAll()
    {
        // 承認済みニュースのみ取得
        $announcements = Announcement::where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        // ビューを返す
        return view('user.news.news_list_all', compact('announcements'));
    }
}
