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
        // 全ユーザーが見れるようにする → コースで絞らない
        $questions = Question::where('is_show', 1)
            ->with(['responder', 'course', 'tag'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.question.questions_list', compact('questions'));
    }
}