<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'explanation',
        'score',
        'order',
        'is_show',
    ];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices()
    {
        // 旧: return $this->hasMany(QuizQuestionChoice::class, 'quiz_question_id', 'id');
        return $this->hasMany(QuizQuestionChoice::class, 'quiz_question_id', 'id');
    }
}
