<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_id', 'started_at', 'completed_at', 'score', 'status', 'attempt_no', 'ip_address'];

    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'attempt_id');
    }
    // ユーザー
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // クイズ
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
