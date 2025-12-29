<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;

class QuizController extends Controller
{
    // クイズ一覧
    public function index()
    {
        $quizzes = Quiz::withCount([
            'questions' => function ($q) {
                $q->where('is_show', 1);
            }
        ])->get();

        return view('user.quizzes.index', compact('quizzes'));
    }

    // クイズ詳細・問題表示
    public function show(Quiz $quiz)
    {
        $questions = $quiz->questions()
            ->with('choices')     // ← 選択肢を出すために必須
            ->where('is_show', 1)
            ->orderBy('order')
            ->get();

        return view('user.quizzes.show', compact('quiz', 'questions'));
    }

    // 回答送信
    public function submit(Request $request, Quiz $quiz)
    {
        abort(404);
    }
}
