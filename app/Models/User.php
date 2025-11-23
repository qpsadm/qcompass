<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, Searchable;

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
        return $this->belongsToMany(Course::class, 'course_users', 'user_id', 'course_id')
            ->withPivot('created_user_name', 'updated_user_name', 'deleted_at', 'deleted_user_name')
            ->withTimestamps()
            ->wherePivotNull('deleted_at'); // ← 必須
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id'); // 外部キーは users.role_id
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    /**
     * Scout 用に検索対象を定義
     */
    public function toSearchableArray(): array
    {
        return [
            'name' => $this->name,
            'code' => $this->code,
            'role_name' => $this->role?->role_name,
            'courses' => $this->courses->pluck('course_name')->implode(' '),
        ];
    }
}
