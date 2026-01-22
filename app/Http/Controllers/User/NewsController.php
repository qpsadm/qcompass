<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Category;
use Illuminate\Support\Collection;

class NewsController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | News一覧（ALL）
    |--------------------------------------------------------------------------
    */
    public function newsListAll(Request $request)
    {
        session(['news_category' => 'all']);
        $courseId = $this->getDisplayCourseId();

        return $this->newsList('all', $request, $courseId);
    }

    /*
    |--------------------------------------------------------------------------
    | 訓練校ニュース（全体記事のみ）
    |--------------------------------------------------------------------------
    */
    public function mainNews(Request $request)
    {
        session(['news_category' => 'main']);
        $courseId = $this->getDisplayCourseId();

        return $this->newsList('main', $request, $courseId);
    }

    /*
    |--------------------------------------------------------------------------
    | 自分の講座ニュース（本講座のみ）
    |--------------------------------------------------------------------------
    */
    public function myNews(Request $request)
    {
        session(['news_category' => 'my']);
        $courseId = $this->getDisplayCourseId();

        return $this->newsList('my', $request, $courseId);
    }

    /*
    |--------------------------------------------------------------------------
    | ニュース一覧 共通処理
    |--------------------------------------------------------------------------
    */
    private function newsList(string $scope, Request $request, ?int $courseId = null)
    {
        $search = $request->input('search');

        $query = Announcement::where('status', 2)
            ->where('is_show', 1);

        if ($scope === 'main') {
            // 全体記事のみ
            $query->whereNull('course_id');
        } elseif ($scope === 'my') {
            // 本講座記事のみ
            if ($courseId) {
                $query->where('course_id', $courseId);
            } else {
                $query->whereRaw('1 = 0');
            }
        } else {
            // ALL（全体 + 本講座）
            $query->where(function ($q) use ($courseId) {
                $q->whereNull('course_id');
                if ($courseId) {
                    $q->orWhere('course_id', $courseId);
                }
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $announcements = $query
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category'      => $scope,
            'categories'    => Category::all(),
            'search'        => $search,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | お知らせ詳細
    |--------------------------------------------------------------------------
    */
    public function news_info(Announcement $announcement)
    {
        $courseId = $this->getDisplayCourseId();
        $categoryScope = session('news_category', 'all');

        $allAnnouncements = $this->getAnnouncementsForPrevNext(
            $categoryScope,
            $courseId
        );

        $currentIndex = $allAnnouncements
            ->search(fn($a) => $a->id === $announcement->id);

        $prevAnnouncement = $currentIndex > 0
            ? $allAnnouncements[$currentIndex - 1]
            : null;

        $nextAnnouncement = $currentIndex < $allAnnouncements->count() - 1
            ? $allAnnouncements[$currentIndex + 1]
            : null;

        return view('user.news.news_info', compact(
            'announcement',
            'prevAnnouncement',
            'nextAnnouncement'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | 前後記事用コレクション取得
    |--------------------------------------------------------------------------
    */
    private function getAnnouncementsForPrevNext(string $scope, ?int $courseId): Collection
    {
        $query = Announcement::where('status', 2)
            ->where('is_show', 1);

        if ($scope === 'main') {
            $query->whereNull('course_id');
        } elseif ($scope === 'my') {
            if ($courseId) {
                $query->where('course_id', $courseId);
            } else {
                $query->whereRaw('1 = 0');
            }
        } else {
            $query->where(function ($q) use ($courseId) {
                $q->whereNull('course_id');
                if ($courseId) {
                    $q->orWhere('course_id', $courseId);
                }
            });
        }

        return $query
            ->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | 表示用講座ID取得（★最重要）
    |--------------------------------------------------------------------------
    | 優先順位
    | 1. なりすまし講座
    | 2. 本講座
    |--------------------------------------------------------------------------
    */
    private function getDisplayCourseId(): ?int
    {
        if (session()->has('impersonator_course_id')) {
            return session('impersonator_course_id');
        }

        return session('course_id');
    }
}
