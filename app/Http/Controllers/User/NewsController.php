<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

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

        // セッションから現在のカテゴリ範囲を取得（デフォルト: 'all'）
        $categoryScope = session('news_category', 'all');

        $baseQuery = Announcement::where('status', 2)
            ->where('is_show', 1);

        // カテゴリ範囲で絞る
        if ($categoryScope === 'main') {
            $baseQuery->whereNull('course_id');
        } elseif ($categoryScope === 'my') {
            $baseQuery->whereIn('course_id', $userCourseIds);
        } else { // all
            $baseQuery->where(function ($q) use ($userCourseIds) {
                $q->whereNull('course_id')
                    ->orWhereIn('course_id', $userCourseIds);
            });
        }

        // 前後の記事取得
        [$prevAnnouncement, $nextAnnouncement] = $this->getPrevNext($baseQuery, $announcement);

        return view('user.news.news_info', compact('announcement', 'prevAnnouncement', 'nextAnnouncement'));
    }

    /**
     * ニュース一覧（ALL）
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

        $announcements = $this->getUserAnnouncements($scope, 5, $search);
        $categories = Category::all();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => $scope,
            'categories' => $categories,
            'search' => $search,
        ]);
    }

    /**
     * ニュース取得共通処理
     */
    private function getUserAnnouncements($scope = 'all', $perPage = 5, $search = null)
    {
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

        return $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
    }

    /**
     * 前後取得
     */
    private function getPrevNext($baseQuery, $current)
    {
        $prev = (clone $baseQuery)
            ->where(function ($q) use ($current) {
                $q->where('created_at', '<', $current->created_at)
                    ->orWhere(function ($sub) use ($current) {
                        $sub->where('created_at', $current->created_at)
                            ->where('id', '<', $current->id);
                    });
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $next = (clone $baseQuery)
            ->where(function ($q) use ($current) {
                $q->where('created_at', '>', $current->created_at)
                    ->orWhere(function ($sub) use ($current) {
                        $sub->where('created_at', $current->created_at)
                            ->where('id', '>', $current->id);
                    });
            })
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->first();

        return [$prev, $next];
    }
}
