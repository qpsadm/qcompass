<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseUser extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        // 他のカラム
    ];

    // ユーザー情報
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 講座情報
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
