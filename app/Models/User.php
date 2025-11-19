<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'furigana',
        'roman_name',
        'password',
        'role_id',
        'division_id',           // 所属部署も追加
        'courses_id',            // 単一コースID
        'remember_token',
        'email',
        'email_verified_at',
        'is_show',
        'created_user_name',     // 名前ベースで作成者を管理
        'updated_user_name',
        'deleted_user_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_show' => 'boolean',
    ];

    // 単一コース用
    public function course()
    {
        return $this->belongsTo(Course::class, 'courses_id');
    }

    // 複数コース用（中間テーブル）
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_users', 'user_id', 'course_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'furigana' => $this->furigana,
        ];
    }
}
