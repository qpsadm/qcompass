<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Announcement;

class NewsController extends Controller
{
    /**
     * お知らせ詳細
     */
    public function news_info(Announcement $announcement)
    {
        $userId = auth()->id();
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        $categoryScope = session('news_category', 'all');

        // 一覧順に全件取得（作成日降順）
        $allAnnouncements = $this->getAnnouncementsForPrevNext($categoryScope, $userCourseIds);

        // 現在記事のキー
        $currentIndex = $allAnnouncements->search(fn($a) => $a->id === $announcement->id);

        // 前後記事
        $prevAnnouncement = $currentIndex > 0 ? $allAnnouncements[$currentIndex - 1] : null;
        $nextAnnouncement = $currentIndex < $allAnnouncements->count() - 1 ? $allAnnouncements[$currentIndex + 1] : null;

        return view('user.news.news_info', compact(
            'announcement',
            'prevAnnouncement',
            'nextAnnouncement'
        ));
    }

    /**
     * 一覧順に全件取得（前後リンク用）
     */
    private function getAnnouncementsForPrevNext($scope, $userCourseIds)
    {
        $query = Announcement::where('status', 2)
            ->where('is_show', 1);

        if ($scope === 'main') {
            $query->whereNull('course_id');
        } elseif ($scope === 'my') {
            $query->whereIn('course_id', $userCourseIds);
        } else { // all
            $query->where(function ($q) use ($userCourseIds) {
                $q->whereNull('course_id')
                    ->orWhereIn('course_id', $userCourseIds);
            });
        }

        // 作成日が新しい順（降順）
        return $query->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * News一覧（ALL）
     */
    public function newsListAll(Request $request)
    {
        session(['news_category' => 'all']);
        return $this->newsList('all', $request);
    }

    /**
     * 訓練校ニュース一覧
     */
    public function mainNews(Request $request)
    {
        session(['news_category' => 'main']);
        return $this->newsList('main', $request);
    }

    /**
     * 自分の講座ニュース一覧
     */
    public function myNews(Request $request)
    {
        session(['news_category' => 'my']);
        return $this->newsList('my', $request);
    }

    /**
     * ニュース一覧の共通処理
     */
    private function newsList($scope, Request $request)
    {
        $search = $request->input('search');
        $userId = auth()->id();
        $userCourseIds = DB::table('course_users')->where('user_id', $userId)->pluck('course_id')->toArray();

        $query = Announcement::where('status', 2)
            ->where('is_show', 1);

        if ($scope === 'main') {
            $query->whereNull('course_id');
        } elseif ($scope === 'my') {
            $query->whereIn('course_id', $userCourseIds);
        } else { // all
            $query->where(function ($q) use ($userCourseIds) {
                $q->whereNull('course_id')
                    ->orWhereIn('course_id', $userCourseIds);
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // 作成日降順でページネート
        $announcements = $query->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => $scope,
            'categories' => \App\Models\Category::all(),
            'search' => $search,
        ]);
    }
}
