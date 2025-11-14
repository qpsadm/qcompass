<?php

// app/Models/Category.php

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
        'top_id',
        'level',
        'child_count',
        'is_show',
        'theme_color',
        'deleted_at',
    ];

    // 再帰的に子カテゴリーを取得
    public function childrenRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('childrenRecursive');
    }

    // 親カテゴリー
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}