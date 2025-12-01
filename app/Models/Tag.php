<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'is_show',
    ];

    protected $casts = [
        'is_show' => 'boolean',
    ];

    // タイムスタンプ無効化
    public $timestamps = false;

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_tags')
            ->withTimestamps()
            ->withPivot([
                'created_user_name',
                'updated_user_name',
                'deleted_user_name',
                'deleted_at'
            ]);
    }
}
