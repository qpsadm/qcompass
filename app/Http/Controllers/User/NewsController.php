<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function news_info(Announcement $announcement)
    {
        return view('user.news.news_info', compact('announcement'));
    }


    // ニュース一覧
    public function newsListAll(Request $request)
    {
        $userId = auth()->id();

        // 自分が所属する講座IDを取得
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        $announcements = Announcement::where('status', 2) // 承認済み
            ->where('is_show', 1) // 表示対象
            ->where(function ($query) use ($userCourseIds) {
                $query->whereNull('course_id') // 訓練校
                    ->orWhereIn('course_id', $userCourseIds); // 自分の講座
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'all',
        ]);
    }

    public function mainNews()
    {
        $announcements = Announcement::where('status', 2)
            ->where('is_show', 1)
            ->whereNull('course_id') // 訓練校だけ
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'main',
        ]);
    }


    public function myNews()
    {
        $userId = auth()->id();

        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        $announcements = Announcement::where('status', 2)
            ->where('is_show', 1)
            ->whereIn('course_id', $userCourseIds) // 訓練校（NULL）は含めない
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'my',
        ]);
    }
}
