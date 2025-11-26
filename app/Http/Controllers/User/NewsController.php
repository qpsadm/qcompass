<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // ニュース一覧
    public function newsListAll()
    {
        // ニュースを取得（例: status が approved のみ）
        $announcements = \App\Models\Announcement::where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        // ビューを返す
        return view('user.news.news_list_all', compact('announcements'));
    }
}
