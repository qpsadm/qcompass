<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'type',
        'time_limit',
        'total_score',
        'passing_score',
        'random_order',
        'active_from',
        'active_to',
        'created_by',
        'category_id', // ←追加
        'level',       // ←追加
    ];

    protected $casts = [
        'type' => 'integer',
        'time_limit' => 'integer',
        'total_score' => 'integer',
        'passing_score' => 'integer',
        'active_from' => 'datetime',
        'active_to' => 'datetime',
    ];

    /**
     * クイズに紐づく問題
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id', 'id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    protected static function booted()
    {
        static::creating(function ($quiz) {
            if (empty($quiz->code)) {
                $quiz->code = 'Q-' . strtoupper(bin2hex(random_bytes(3)));
            }
        });
    }
}
