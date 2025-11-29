<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index($category = null)
    {
        $category = $category ?? 'all';

        $questions = \App\Models\Question::where('is_show', 1);

        if ($category === 'main') {
            $questions->where('course_id', $this->mainCourseId ?? 1);
        } elseif ($category === 'my') {
            $questions->where('responder_id', auth()->id());
        }

        $questions = $questions->orderBy('created_at', 'desc')->paginate(10);

        return view('user.question.questions_list', [
            'category' => $category,
            'questions' => $questions,
        ]);
    }
}
