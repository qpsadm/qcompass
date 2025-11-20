<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    protected $table = 'course_categorys';

    protected $fillable = [
        'course_id',
        'category_id',
        'note',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    // ソフトデリート対応
    protected $dates = ['deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
