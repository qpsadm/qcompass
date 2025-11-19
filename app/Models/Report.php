<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'course_id',
        'date',
        'title',
        'content',
        'impression',
        'notice',
        'user_id',
        'created_user_id',
        'updated_user_id',
    ];

    // 提出者（user_id）
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // 作成者（created_user_id）
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    // 更新者（updated_user_id）
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }

    // 講座
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
