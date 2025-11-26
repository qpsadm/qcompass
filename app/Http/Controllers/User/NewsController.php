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



    public function myNews(Request $request)
    {
        $user = auth()->user();  // ユーザーオブジェクト
        $userId = auth()->id();

        // ユーザーが所属する講座IDを配列で取得
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')   // 複数講座に所属している場合も対応
            ->toArray();

        // 承認済み & 表示対象 & 訓練校または自分の講座のお知らせを取得
        $announcements = Announcement::where('is_show', 1)
            ->where('status', 2)
            ->where(function ($query) use ($userCourseIds) {
                $query->whereNull('course_id')          // 訓練校のお知らせ
                    ->orWhereIn('course_id', $userCourseIds); // 自分の講座
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'my', // Bladeでアクティブ表示用
        ]);
    }
}
