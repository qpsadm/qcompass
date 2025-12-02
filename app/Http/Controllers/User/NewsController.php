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
     * 個別ニュース詳細
     */
    // App\Http\Controllers\User\NewsController.php

    public function news_info(Announcement $announcement)
    {
        // 現在認証されているユーザーのコースIDを取得（getUserAnnouncementsメソッドのロジックを流用）
        $userId = auth()->id();
        $userCourseIds = DB::table('course_users')->where('user_id', $userId)->pluck('course_id')->toArray();

        // ユーザーが閲覧可能な記事のベースとなるクエリ
        $baseQuery = Announcement::where('status', 2) // 公開中
            ->where('is_show', 1) // 表示
            ->where(function ($q) use ($userCourseIds) {
                // 全員向け OR 自分の所属コース向け
                $q->whereNull('course_id')
                    ->orWhereIn('course_id', $userCourseIds);
            });

        // 1. 前の記事を取得 (created_atが古く、ソート順で一つ前になる記事)
        $prevAnnouncement = (clone $baseQuery)
            ->where(function ($q) use ($announcement) {
                // 現在の記事より古い投稿日時
                $q->where('created_at', '<', $announcement->created_at);

                // または、投稿日時が同じでIDが小さいもの (IDは記事IDの昇順として使用)
                $q->orWhere(function ($sub) use ($announcement) {
                    $sub->where('created_at', $announcement->created_at)
                        ->where('id', '<', $announcement->id);
                });
            })
            ->orderBy('created_at', 'desc') // 新しい順に並べて、最初に来るものが「前」
            ->orderBy('id', 'desc')
            ->first();

        // 2. 次の記事を取得 (created_atが新しく、ソート順で一つ後になる記事)
        $nextAnnouncement = (clone $baseQuery)
            ->where(function ($q) use ($announcement) {
                // 現在の記事より新しい投稿日時
                $q->where('created_at', '>', $announcement->created_at);

                // または、投稿日時が同じでIDが大きいもの
                $q->orWhere(function ($sub) use ($announcement) {
                    $sub->where('created_at', $announcement->created_at)
                        ->where('id', '>', $announcement->id);
                });
            })
            ->orderBy('created_at', 'asc') // 古い順に並べて、最初に来るものが「次」
            ->orderBy('id', 'asc')
            ->first();

        // 3. 前後の記事情報をビューに渡す
        return view('user.news.news_info', compact('announcement', 'prevAnnouncement', 'nextAnnouncement'));
    }

    /**
     * ニュース一覧（ALL）
     */
    public function newsListAll(Request $request)
    {
        $search = $request->input('search'); // フォームの検索文字列
        $announcements = $this->getUserAnnouncements('all', 5, $search);

        // カテゴリ一覧（Bladeで使う）
        $categories = \App\Models\Category::all();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'all',
            'categories' => $categories,
            'search' => $search,
        ]);
    }
    /**
     * 訓練校ニュース一覧
     */
    public function mainNews(Request $request)
    {
        $search = $request->input('search');
        $announcements = $this->getUserAnnouncements('main', 5, $search);

        $categories = Category::all();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'main',
            'categories' => $categories,
            'search' => $search,
        ]);
    }

    /**
     * 自分の講座ニュース一覧
     */
    public function myNews(Request $request)
    {
        $search = $request->input('search');
        $announcements = $this->getUserAnnouncements('my', 5, $search);

        $categories = Category::all();

        return view('user.news.news_list', [
            'announcements' => $announcements,
            'category' => 'my',
            'categories' => $categories,
            'search' => $search,
        ]);
    }


    /**
     * ユーザー用ニュース取得共通処理
     *
     * @param string $scope 'all'|'main'|'my'
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getUserAnnouncements($scope = 'all', $perPage = 5, $search = null)
    {
        $userId = auth()->id();

        $userCourseIds = DB::table('course_users')
            ->where('user_id', $userId)
            ->pluck('course_id')
            ->toArray();

        $query = Announcement::where('status', 2)
            ->where('is_show', 1);

        if ($scope === 'main') {
            $query->whereNull('course_id');
        } elseif ($scope === 'my') {
            $query->whereIn('course_id', $userCourseIds);
        } else {
            $query->where(function ($q) use ($userCourseIds) {
                $q->whereNull('course_id')
                    ->orWhereIn('course_id', $userCourseIds);
            });
        }

        // 検索文字列で絞り込み
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
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