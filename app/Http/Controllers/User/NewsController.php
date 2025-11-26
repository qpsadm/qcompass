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


    public function newsListAll()
    {
        // 承認済みのみ取得
        $announcements = Announcement::where('status', 'is_show')
            ->orderBy('created_at', 'desc')
            ->get();

        // Blade に渡す
        return view('user.news.news_list', compact('announcements'));
    }
}
