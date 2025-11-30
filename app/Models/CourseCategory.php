<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    // リレーション
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // booted で作成者・更新者・削除者を自動セット
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
            $model->save(); // SoftDeletes でも削除時に保存
        });
    }
}
