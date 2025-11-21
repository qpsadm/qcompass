<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizAnswer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'choice_id',
        'answer_text',
        'is_correct',
        'score',
        'user_id',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];
    public function attempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function choice()
    {
        return $this->belongsTo(QuizQuestionChoice::class, 'choice_id');
    }
}
