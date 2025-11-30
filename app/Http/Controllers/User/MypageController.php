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
        // ユーザーの受講講座を取得
        $courses = $user->myCourses()->get(); // 表示フラグがある講座だけ

        $pending = [];

        foreach ($courses as $course) {
            $start = \Carbon\Carbon::parse($course->start_date);
            $end   = \Carbon\Carbon::parse($course->end_date);

            $period = new \DatePeriod(
                $start,
                new \DateInterval('P1D'),
                $end->copy()->addDay() // 終了日も含める
            );

            foreach ($period as $date) {
                // 日報提出済みか確認
                $exists = $user->reports()
                    ->where('course_id', $course->id)
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
