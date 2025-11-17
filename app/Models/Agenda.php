<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agendas';

    protected $fillable = [
        'agenda_name',
        'category_id',
        'description',
        'is_show',
        'user_id',
        'accept',
        'created_user_id',
        'updated_user_id',
    ];
    protected $casts = [
        'is_show' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    //お知らせの取得
    public function scopeNotice($query)
    {
        return $query->where('name', 'お知らせ');
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategorys::class, 'category_id', 'category_id');
    }

    public function course()
    {
        return $this->hasOneThrough(
            Course::class,
            CourseCategorys::class,
            'category_id', // 中間テーブルの外部キー
            'id',          // Course の主キー
            'category_id', // Agenda の category_id
            'course_id'    // CourseCategory の course_id
        );
    }
}
