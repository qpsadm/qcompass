<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTeacher extends Model
{
    use SoftDeletes;
    protected $table = 'course_teachers';
    protected $fillable = [
        'course_id',
        'user_id',
        'role_in_course',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];
    // 講座
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // 講師ユーザー
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    // 担当区分を文字列で出したい場合
    public function getRoleNameAttribute()
    {
        return match ($this->role_in_course) {
            1 => '責任者',
            2 => '講師',
            3 => 'キャリコン',
            4 => '補助',
            default => '未設定',
        };
    }
}
