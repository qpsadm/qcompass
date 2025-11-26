<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Agenda;
use App\Models\Quiz;
use App\Models\Report;
use App\Models\Announcement;

class UserController extends Controller
{
    /**
     * ユーザーダッシュボード
     */
    public function dashboard()
    {
        $announcements = Announcement::where('is_show', 1)
            ->latest()
            ->take(5)
            ->get();

        return view('user.dashboard', compact('announcements'));
    }

    /**
     * 講座詳細
     */
    public function courseDetail(Course $course)
    {
        $agendas = $course->agendas; // 講座に紐づくアジェンダ
        $quizzes = $course->quizzes; // 講座に紐づくクイズ

        return view('user.course_detail', compact('course', 'agendas', 'quizzes'));
    }

    /**
     * アジェンダ閲覧
     */
    public function showAgenda(Agenda $agenda)
    {
        return view('user.agenda', compact('agenda'));
    }

    /**
     * クイズ一覧
     */
    public function quizzes()
    {
        $quizzes = Quiz::all(); // 受講可能なクイズ一覧
        return view('user.quizzes.index', compact('quizzes'));
    }

    /**
     * クイズ詳細（提出は UserQuizController に委任）
     */
    public function showQuiz(Quiz $quiz)
    {
        return redirect()->route('user.quizzes.show', $quiz->id);
    }

    /**
     * レポート一覧
     */
    public function reports()
    {
        $reports = Report::all(); // ユーザーが閲覧可能なレポート
        return view('user.reports.index', compact('reports'));
    }

    /**
     * レポート詳細
     */
    public function showReport(Report $report)
    {
        return view('user.reports.show', compact('report'));
    }
}