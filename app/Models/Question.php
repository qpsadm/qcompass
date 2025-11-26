<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'asker_id',
        'target_id',
        'course_id',
        'title',
        'responder_id',
        'content',
        'answer',
        'is_show',
        'tag_id', 
        'deleted_at'
    ];

    // 講座
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // 回答講師
    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }

    // タグ（1対1）
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    // 講座ごとの担当講師（Alpine.js用）
    public function course_teachers()
    {
        return $this->hasMany(CourseTeacher::class, 'user_id', 'id');
    }
}
