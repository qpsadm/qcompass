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
    public function newsListAll()
    {
        // 承認済み or 表示対象のみ取得
        $announcements = Announcement::where('status', 2) // status 2 が表示用
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.news.news_list', compact('announcements'));
    }
}
