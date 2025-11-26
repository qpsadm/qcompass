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
        'content',
        'is_show',
        'user_id',
        'status',
        'created_user_name',
        'updated_user_name',
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
        return $this->belongsTo(User::class, 'created_user_name');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_name');
    }
    public function files()
    {
        return $this->morphMany(AgendaFile::class, 'target');
    }
    // course を安全に取得するアクセサ
    public function getCourseAttribute()
    {
        return $this->category ? $this->category->course : null;
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_agendas', 'target_id', 'course_id');
    }
}