<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTeacher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'course_id',
        'user_id',
        'role_in_course',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 担当区分の文字列化
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

    // booted メソッド
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->created_user_name = $model->created_user_name ?? auth()->user()->name ?? 'system';
        });

        static::updating(function ($model) {
            $model->updated_user_name = auth()->user()->name ?? 'system';
        });

        static::deleting(function ($model) {
            $model->deleted_user_name = auth()->user()->name ?? 'system';
            $model->save();
        });
    }
}
