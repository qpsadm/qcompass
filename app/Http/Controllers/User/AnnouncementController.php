<?php

namespace App\Http\Controllers;

use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function show(Announcement $announcement)
    {
        return view('announcements.show', compact('announcement'));
    }
}