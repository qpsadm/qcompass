<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'course_id',
        'date',
        'title',
        'content',
        'impression',
        'notice',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    // 提出者
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 作成者
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_user_name');
    }

    // 更新者
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_user_name');
    }

    // 講座
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::creating(function ($model) {
            $userName = Auth::user()->name ?? 'system';

            $model->created_user_name = $model->created_user_name ?? $userName;
            $model->updated_user_name = $model->updated_user_name ?? $userName;
        });

        static::updating(function ($model) {
            $model->updated_user_name = Auth::user()->name ?? 'system';
        });

        static::deleting(function ($model) {
            $model->deleted_user_name = Auth::user()->name ?? 'system';
            $model->saveQuietly(); // 無限ループ防止
        });
    }
}
