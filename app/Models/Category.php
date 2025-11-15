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
        'theme_color'
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
}
