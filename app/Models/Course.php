<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Builder;

class Course extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $table = 'courses';

    protected $fillable = [
        'course_code',
        'course_type_id',
        'level_id',
        'organizer_id',
        'course_name',
        'venue',
        'application_date',
        'certification_date',
        'certification_number',
        'start_date',
        'end_date',
        'total_hours',
        'periods',
        'start_time',
        'finish_time',
        'start_viewing',
        'finish_viewing',
        'plan_path',
        'flier_path',
        'capacity',
        'entering',
        'completed',
        'description',
        'mail_address',
        'cc_address',
        'status',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    protected $casts = [
        'is_show' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Events（作成者・更新者・削除者）
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $name = Auth::user()->name;
                $model->created_user_name = $name;
                $model->updated_user_name = $name;
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_user_name = Auth::user()->name;
            }
        });

        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_user_name = Auth::user()->name;
                $model->saveQuietly(); // 無限ループ防止
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users', 'course_id', 'user_id')
            ->withPivot('created_user_name', 'updated_user_name', 'deleted_at', 'deleted_user_name')
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }

    public function students()
    {
        return $this->users();
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'course_teachers', 'course_id', 'user_id')
            ->where('role_id', '>=', 4)
            ->whereNull('course_teachers.deleted_at')
            ->wherePivotNull('deleted_at');
    }

    public function agendas()
    {
        return $this->belongsToMany(Agenda::class, 'course_agendas', 'course_id', 'target_id')
            ->withPivot('order_no', 'note')
            ->withTimestamps();
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'course_categories', 'course_id', 'category_id')
            ->withPivot(['note', 'is_show'])
            ->withTimestamps();
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'course_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Status 定義
    |--------------------------------------------------------------------------
    */
    const STATUS_DRAFT     = 0;
    const STATUS_ARCHIVED  = 1;
    const STATUS_PUBLISHED = 2;

    const STATUS = [
        self::STATUS_DRAFT     => '開校準備',
        self::STATUS_ARCHIVED  => '終了',
        self::STATUS_PUBLISHED => '実施中',
    ];

    /*
    |--------------------------------------------------------------------------
    | ログイン判定ロジック
    |--------------------------------------------------------------------------
    */
    public function isLoginable(): bool
    {
        $now = now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date) {
            return $now->lte(
                \Carbon\Carbon::parse($this->end_date)->addMonth()->endOfDay()
            );
        }

        return true;
    }

    public function loginRemainingDays(): ?int
    {
        if ($this->end_date === null) {
            return null;
        }

        $limit = Carbon::parse($this->end_date)->addMonth()->endOfDay();

        if (now()->gt($limit)) {
            return 0;
        }

        return now()->diffInDays($limit);
    }

    public function loginStatusLabel(): array
    {
        if (!$this->isLoginable()) {
            return ['icon' => '🔒', 'text' => 'ログイン不可'];
        }

        $days = $this->loginRemainingDays();

        if ($days === null) {
            return ['icon' => '🔓', 'text' => '常にログイン可'];
        }

        return ['icon' => '🔓', 'text' => "ログイン可（残り{$days}日）"];
    }

    public function getLoginRemainingDaysAttribute(): ?int
    {
        if (!$this->end_date) return null;

        $limit = \Carbon\Carbon::parse($this->end_date)->addMonth()->endOfDay();
        $days = now()->diffInDays($limit, false);

        return $days > 0 ? $days : 0;
    }

    /*
    |--------------------------------------------------------------------------
    | ログイン画面に表示するコース（SQL上で不可を除外）
    |--------------------------------------------------------------------------
    */
    // public function scopeLoginVisible(Builder $query)
    // {
    //     $now = now();

    //     return $query
    //         ->where('is_show', 1)
    //         ->where(function ($q) use ($now) {
    //             // 開始前を除外
    //             $q->whereNull('start_date')
    //                 ->orWhere('start_date', '<=', $now);
    //         })
    //         ->where(function ($q) use ($now) {
    //             // 終了日未設定 → OK
    //             $q->whereNull('end_date')
    //                 // 終了日＋1か月 >= today → OK
    //                 ->orWhere('end_date', '>=', $now->copy()->subMonth());
    //         });
    // }

    /*
    |--------------------------------------------------------------------------
    | ログイン画面に表示するコース（表示フラグのみ）
    |--------------------------------------------------------------------------
    */
    public function scopeShowOnLogin(Builder $query)
    {
        return $query
            ->where('is_show', 1)
            ->whereNull('deleted_at');
    }

    // 修了までの日数
    public function getRemainingDaysAttribute(): ?int
    {
        if ($this->end_date === null) {
            return null;
        }

        $remaining = now()->diffInDays(
            Carbon::parse($this->end_date)->endOfDay(),
            false
        );

        return $remaining > 0 ? $remaining : 0;
    }

    public function studentsCount(): int
    {
        return $this->students()->count();
    }
}
