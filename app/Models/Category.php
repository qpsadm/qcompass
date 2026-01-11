<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'parent_id',
        'level',
        'top_id',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        // 作成時
        static::creating(function ($model) {
            if (Auth::check()) {
                $name = Auth::user()->name;
                $model->created_user_name = $name;
                $model->updated_user_name = $name;
            }
        });

        // 更新時
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_user_name = Auth::user()->name;
            }
        });

        // 削除時（SoftDelete）
        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_user_name = Auth::user()->name;
                $model->saveQuietly(); // 無限ループ防止
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // 子カテゴリ
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id')
            ->with('childrenRecursive');
    }

    // 動的に子数を返す
    public function getChildCountAttribute()
    {
        return $this->childrenRecursive()->count();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_categories', 'category_id', 'course_id')
            ->withPivot(['note', 'is_show'])
            ->withTimestamps();
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'category_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * このカテゴリに属するクイズ
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
