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
        // 記述式
        if ($this->type === 'text') {
            return true;
        }

        $correctChoices = $this->choices->where('is_correct', true);

        if ($correctChoices->isEmpty()) {
            return false;
        }

        // ==========================
        // 単一選択
        // ==========================
        if (in_array($this->type, ['single_2', 'single_4'])) {

            if (!is_scalar($answer)) {
                return false;
            }

            return (int)$correctChoices->first()->id === (int)$answer;
        }

        // ==========================
        // 複数選択
        // ==========================
        if ($this->type === 'multi') {

            if (!is_array($answer)) {
                return false;
            }

            // 🔑 全部 int に揃える
            $correctIds = $correctChoices
                ->pluck('id')
                ->map(fn($id) => (int)$id)
                ->sort()
                ->values();

            $answerIds = collect($answer)
                ->map(fn($id) => (int)$id)
                ->sort()
                ->values();

            // 🔑 差分がなければ完全一致
            return $correctIds->diff($answerIds)->isEmpty()
                && $answerIds->diff($correctIds)->isEmpty();
        }

        return false;
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
