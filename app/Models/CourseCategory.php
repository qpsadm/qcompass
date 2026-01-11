<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class CourseCategory extends Model
{
    use SoftDeletes;

    protected $table = 'course_categories';

    protected $fillable = [
        'course_id',
        'category_id',
        'note',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    protected $dates = ['deleted_at'];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
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
            $model->saveQuietly(); // ← 重要
        });
    }
}
