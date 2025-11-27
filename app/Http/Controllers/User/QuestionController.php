<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 生徒が所属しているコースIDを取得
        $courseIds = $user->courses()->pluck('courses.id');

        // 所属コースの質問を取得
        $questions = Question::whereIn('course_id', $courseIds)
            ->where('is_show', 1)
            ->with(['responder', 'course', 'tag']) // agendaは除外
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.question.questions_list', compact('questions'));
    }
}
