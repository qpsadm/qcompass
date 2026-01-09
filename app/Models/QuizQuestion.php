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
    /**
     * 回答が正解かどうか判定
     */
    public function isCorrect($answer): bool
    {
        // 正解選択肢を取得
        $correctChoice = $this->choices
            ->where('is_correct', 1)
            ->first();

        if (!$correctChoice) {
            return false;
        }

        // 単一選択（radio / select）
        return (string) $correctChoice->id === (string) $answer;
    }

    protected static function booted()
    {
        static::deleting(function ($question) {
            if ($question->isForceDeleting()) {
                $question->choices()->forceDelete();
            } else {
                $question->choices()->delete();
                // $question->answers()->delete();
            }
        });
    }
}
