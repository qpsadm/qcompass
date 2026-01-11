<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    // 担当区分の文字列化
    public function getRoleNameAttribute(): string
    {
        return match ($this->role_in_course) {
            1 => '責任者',
            2 => '講師',
            3 => 'キャリコン',
            4 => '補助',
            default => '未設定',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events（作成者・更新者・削除者）
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        // 作成時
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_user_name = Auth::user()->name;
                $model->updated_user_name = Auth::user()->name;
            } else {
                $model->created_user_name = 'system';
                $model->updated_user_name = 'system';
            }
        });

        // 更新時
        static::updating(function ($model) {
            $model->updated_user_name = Auth::user()->name ?? 'system';
        });

        // 削除時（SoftDelete）
        static::deleting(function ($model) {
            $model->deleted_user_name = Auth::user()->name ?? 'system';
            $model->saveQuietly(); // ← 超重要
        });
    }
}
