<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;
use Illuminate\Support\Facades\Auth;

class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user_details = $user->detail;

        // 未提出日報
        $pending_diaries = $this->getPendingDiaries($user);

        // 提出済み日報（同じ日付は1件だけ）
        $submitted_reports = $user->reports()
            ->select('date', 'id') // idは何か1件だけ残すため
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // お知らせ
        $announcements = Announcement::latest()->take(5)->get();

        return view('user.mypage.mypage', compact(
            'user',
            'user_details',
            'pending_diaries',
            'submitted_reports',
            'announcements'
        ));
    }

    private function getPendingDiaries($user)
    {
        $courses = $user->myCourses()->get();
        $pending = [];

        foreach ($courses as $course) {
            $start = \Carbon\Carbon::parse($course->start_date);
            $end   = \Carbon\Carbon::parse($course->end_date);

            $period = new \DatePeriod(
                $start,
                new \DateInterval('P1D'),
                $end->copy()->addDay()
            );

            foreach ($period as $date) {
                $exists = $user->reports()
                    ->where('course_id', $course->id)
                    ->whereDate('date', $date)
                    ->exists();

                if (!$exists) {
                    $diary = new \stdClass();
                    $diary->date = $date->format('Y-m-d');
                    $diary->course_id = $course->id;
                    $diary->course_name = $course->course_name;
                    // 日報作成URLをここで生成
                    $diary->url = route('user.reports_create', [
                        'course_id' => $course->id,
                        'date' => $date->format('Y-m-d')
                    ]);

                    $pending[] = $diary;
                }
            }
        }

        // 日付でユニークにして、同じ日が複数の講座でも1件だけにする
        $pending = collect($pending)->unique('date')->values()->all();

        return $pending;
    }
}
