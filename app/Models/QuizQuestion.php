<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuizQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'explanation',
        'score',
        'order',
        'is_show',
        'type',
    ];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices()
    {
        return $this->hasMany(QuizQuestionChoice::class, 'quiz_question_id', 'id');
    }

    protected static function booted()
    {
        static::deleting(function ($question) {
            if ($question->isForceDeleting()) {
                $question->choices()->forceDelete();
                $question->answers()->forceDelete();
            } else {
                $question->choices()->delete();
                // $question->answers()->delete();
            }
        });
    }
}
