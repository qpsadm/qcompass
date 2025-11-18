<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestionChoice extends Model
{
    protected $fillable = [
        'quiz_question_id',
        'choice_text',
        'is_correct'
    ];

    public function quizQuestion()
    {
        return $this->belongsTo(QuizQuestion::class);
    }
}
