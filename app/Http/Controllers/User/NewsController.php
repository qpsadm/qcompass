<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * 個別ニュース詳細
     */
    public function news_info(Announcement $announcement)
    {
        return view('user.news.news_info', compact('announcement'));
    }

    /**
     * ニュース一覧（ALL）
     */
    public function newsListAll()
    {
        $announcements = $this->getUserAnnouncements('all');

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'all',
        ]);
    }

    /**
     * 訓練校ニュース一覧
     */
    public function mainNews()
    {
        $announcements = $this->getUserAnnouncements('main');

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'main',
        ]);
    }

    /**
     * 自分の講座ニュース一覧
     */
    public function myNews()
    {
        $announcements = $this->getUserAnnouncements('my');

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'my',
        ]);
    }

    /**
     * ユーザー用ニュース取得共通処理
     *
     * @param string $scope 'all'|'main'|'my'
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getUserAnnouncements($scope = 'all', $perPage = 5)
    {
        $userId = auth()->id();

        // ユーザーが所属する講座IDを配列で取得
        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        $query = Announcement::where('status', 2)  // 承認済み
            ->where('is_show', 1);                // 表示対象

        if ($scope === 'main') {
            // 訓練校のみ（course_id が NULL）
            $query->whereNull('course_id');
        } elseif ($scope === 'my') {
            // 自分の講座のみ（訓練校は含めない）
            $query->whereIn('course_id', $userCourseIds);
        } else {
            // ALL → 訓練校 + 自分の講座
            $query->where(function ($q) use ($userCourseIds) {
                $q->whereNull('course_id')
                    ->orWhereIn('course_id', $userCourseIds);
            });
        }

        // ページネーション対応
        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * ダッシュボード用ニュース取得
     */
    public function dashboard()
    {
        // ダッシュボードではALLを取得（自分の講座 + 訓練校）
        $announcements = $this->getUserAnnouncements('all');

        return view('user.top', compact('announcements'));
    }
}
