<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use App\Models\Category;
use Illuminate\Support\Collection;

class NewsController extends Controller
{
    /**
     * News一覧（ALL）
     */
    public function newsListAll(Request $request)
    {
        session(['news_category' => 'all']);
        $courseId = session('course_id');
        return $this->newsList('all', $request, $courseId);
    }

    /**
     * 訓練校ニュース一覧（全体記事のみ）
     */
    public function mainNews(Request $request)
    {
        session(['news_category' => 'main']);
        $courseId = session('course_id');
        return $this->newsList('main', $request, $courseId);
    }

    /**
     * 自分の講座ニュース一覧（本講座記事のみ）
     */
    public function myNews(Request $request)
    {
        session(['news_category' => 'my']);
        $courseId = session('course_id');
        return $this->newsList('my', $request, $courseId);
    }

    /**
     * ニュース一覧共通処理
     *
     * @param string $scope all | main | my
     * @param Request $request
     * @param int|null $courseId
     */
    private function newsList(string $scope, Request $request, ?int $courseId = null)
    {
        $search = $request->input('search');

        $query = Announcement::where('status', 2)
            ->where('is_show', 1);

        if ($scope === 'main') {
            $query->whereNull('course_id'); // 全体記事のみ
        } elseif ($scope === 'my') {
            if ($courseId) {
                $query->where('course_id', $courseId); // 本講座記事のみ
            } else {
                // 本講座未設定なら何も出さない
                $query->whereRaw('1 = 0');
            }
        } else { // all
            $query->where(function ($q) use ($courseId) {
                $q->whereNull('course_id'); // 全体記事
                if ($courseId) {
                    $q->orWhere('course_id', $courseId); // 本講座記事
                }
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $announcements = $query->orderBy('updated_at', 'desc')
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

    /**
     * お知らせ詳細
     */
    public function news_info(Announcement $announcement)
    {
        $courseId = session('course_id');
        $categoryScope = session('news_category', 'all');

        $allAnnouncements = $this->getAnnouncementsForPrevNext($categoryScope, $courseId);

        $currentIndex = $allAnnouncements->search(fn($a) => $a->id === $announcement->id);

        $prevAnnouncement = $currentIndex > 0 ? $allAnnouncements[$currentIndex - 1] : null;
        $nextAnnouncement = $currentIndex < $allAnnouncements->count() - 1 ? $allAnnouncements[$currentIndex + 1] : null;

        return view('user.news.news_info', compact(
            'announcement',
            'prevAnnouncement',
            'nextAnnouncement'
        ));
    }

    /**
     * 前後記事用のコレクションを取得
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
        } else { // all
            $query->where(function ($q) use ($courseId) {
                $q->whereNull('course_id');
                if ($courseId) {
                    $q->orWhere('course_id', $courseId);
                }
            });
        }

        return $query->orderBy('updated_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();
    }
}
