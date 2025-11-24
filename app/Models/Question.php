<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['asker_id', 'agenda_id', 'course_id', 'title', 'responder_id', 'content', 'answer', 'is_show', 'deleted_at'];


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

    public function course_teachers()
    {
        return $this->hasMany(CourseTeacher::class, 'user_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tags')
            ->withTimestamps()
            ->withPivot([
                'created_user_name',
                'updated_user_name',
                'deleted_user_name',
                'deleted_at'
            ]);
    }
}
