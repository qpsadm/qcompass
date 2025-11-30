<?php
// app/Http/Controllers/User/MypageController.php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;
use App\Models\UserDetail;


class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // user_details（存在しない時もあるので first() を使う）
        $user_details = UserDetail::where('user_id', $user->id)->first();

        // お知らせ
        $announcements = Announcement::latest()->take(5)->get();

        // 未提出日記
        $unsubmitted_reports = $this->getPendingDiaries($user);

        return view('user.mypage.mypage', compact(
            'user',
            'user_details',
            'unsubmitted_reports',
            'announcements'
        ));
    }

    private function getPendingDiaries($user)
    {
        // ユーザーが受講している講座を取得（例: enrollments テーブルがある場合）
        // ※ あなたの環境に合わせて書き換えてください
        $courses = \App\Models\Course::where('organizer_id', $user->id)->get();

        $pending = [];

        foreach ($courses as $course) {

            // 開催期間
            $start = \Carbon\Carbon::parse($course->start_date);
            $end   = \Carbon\Carbon::parse($course->end_date);

            // コース期間の全日付を生成
            $period = new \DatePeriod(
                $start,
                new \DateInterval('P1D'),
                $end->copy()->addDay()
            );

            foreach ($period as $date) {
                // 日報が提出されているかチェック（Diary モデルは例）
                $exists = \App\Models\Report::where('user_id', $user->id)
                    ->whereDate('date', $date)
                    ->exists();

                if (!$exists) {
                    $pending[] = [
                        'date' => $date->format('Y-m-d'),
                        'course_name' => $course->course_name,
                    ];
                }
            }
        }

        return $pending;
    }
}
