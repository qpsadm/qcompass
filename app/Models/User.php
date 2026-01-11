<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Auth;

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
        'division_id',
        'courses_id',
        'remember_token',
        'email',
        'email_verified_at',
        'is_show',
        'created_user_name',
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

    /*
    |--------------------------------------------------------------------------
    | Model Events（作成者・更新者・削除者の自動記録）
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::creating(function ($model) {
            $userName = Auth::user()->name ?? 'system';
            $model->created_user_name = $model->created_user_name ?? $userName;
            $model->updated_user_name = $model->updated_user_name ?? $userName;
        });

        static::updating(function ($model) {
            $model->updated_user_name = Auth::user()->name ?? 'system';
        });

        static::deleting(function ($model) {
            $model->deleted_user_name = Auth::user()->name ?? 'system';
            $model->saveQuietly(); // SoftDelete用（無限ループ防止）
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // 単一コース
    public function course()
    {
        return $this->belongsTo(Course::class, 'courses_id');
    }

    // 複数コース
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_users', 'user_id', 'course_id')
            ->withPivot(
                'created_user_name',
                'updated_user_name',
                'deleted_at',
                'deleted_user_name'
            )
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }

    public function myCourses()
    {
        return $this->courses()
            ->where('is_show', 1)
            ->select([
                'courses.id',
                'courses.course_name',
                'courses.start_date',
                'courses.end_date',
                'courses.plan_path',
                'courses.flier_path',
            ])
            ->withPivot('created_user_name', 'updated_user_name');
    }

    public function course_teachers()
    {
        return $this->hasMany(CourseTeacher::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    public function theme()
    {
        return $this->detail->theme();
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function coursesAsTeacher()
    {
        return $this->belongsToMany(Course::class, 'course_teachers', 'user_id', 'course_id')
            ->withPivot('role_in_course');
    }

    /*
    |--------------------------------------------------------------------------
    | Scout Search
    |--------------------------------------------------------------------------
    */
    public function toSearchableArray(): array
    {
        return [
            'name'       => $this->name,
            'code'       => $this->code,
            'role_name'  => $this->role?->role_name,
            'courses'    => $this->courses->pluck('course_name')->implode(' '),
        ];
    }
}
