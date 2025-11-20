<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    ];

    // 子カテゴリ
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('childrenRecursive');
    }

    // 動的に子数を返す
    public function getChildCountAttribute()
    {
        return $this->childrenRecursive()->count();
    }


    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_categorys', 'category_id', 'course_id')
            ->withPivot(['note', 'is_show'])
            ->withTimestamps();
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id'); // categoriesテーブルに theme_id がある場合
    }
}
