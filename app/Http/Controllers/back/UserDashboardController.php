<?php
use App\Models\Announcement;

public function dashboard()
{
    $announcements = Announcement::with('type')
        ->where('is_show', 1)
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    return view('user.top', compact('announcements'));
}