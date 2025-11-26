<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function show(Announcement $announcement)
    {
        return view('user.announcements.show', compact('announcement'));
    }

    public function newsListAll()
    {
        $announcements = \App\Models\Announcement::where('status', 'is_show')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.news.news_list', compact('announcements'));
    }
}
