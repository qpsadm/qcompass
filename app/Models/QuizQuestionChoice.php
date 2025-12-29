<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestionChoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quiz_question_id',
        'choice_text',
        'is_correct',
        'order',
    ];

    public function question()
    {
        return $this->belongsTo(
            QuizQuestion::class,
            'quiz_question_id',
            'id'
        );
    }
}
