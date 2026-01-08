<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Course extends Model
{
    use HasFactory, SoftDeletes, Searchable;

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
        'mail_address',   // ← 追加
        'cc_address',     // ← 追加
        'status',
        'is_show',
        'created_user_name',
        'updated_user_name'
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users', 'course_id', 'user_id')
            ->withPivot('created_user_name', 'updated_user_name', 'deleted_at', 'deleted_user_name')
            ->withTimestamps()
            ->wherePivotNull('deleted_at'); // ← ここで削除済み除外
    }

    // 状態定義
    const STATUS_DRAFT     = 0; // 開校準備
    const STATUS_ARCHIVED  = 1; // 終了
    const STATUS_PUBLISHED = 2; // 実施中

    const STATUS = [
        self::STATUS_DRAFT     => '開校準備',
        self::STATUS_ARCHIVED  => '終了',
        self::STATUS_PUBLISHED => '実施中',
    ];

    public function agendas()
    {
        return $this->belongsToMany(
            Agenda::class,
            'course_agendas',
            'course_id',
            'target_id'
        )->withPivot('order_no', 'note')
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
        return $this->hasMany(\App\Models\Quiz::class, 'course_id');
    }
    public function teachers()
    {
        // 中間テーブル: course_teachers
        // 外部キー: course_id
        // 関連キー: user_id
        return $this->belongsToMany(User::class, 'course_teachers', 'course_id', 'user_id')
            ->where('role_id', '>=', 4) // 講師の条件
            ->whereNull('course_teachers.deleted_at') // 論理削除対応
            ->wherePivotNull('deleted_at'); // ← 同様
    }

    public function students()
    {
        return $this->belongsToMany(
            User::class,
            'course_users',
            'course_id',
            'user_id'
        )
            ->withPivot('created_user_name', 'updated_user_name', 'deleted_at', 'deleted_user_name')
            ->withTimestamps()
            ->wherePivotNull('deleted_at');
    }

    public function getRemainingDaysAttribute()
    {
        $today = now()->startOfDay();
        $endDate = \Carbon\Carbon::parse($this->end_date)->startOfDay();

        $diff = $today->diffInDays($endDate, false); // 過ぎていたらマイナス
        return $diff > 0 ? $diff : 0;
    }


    // ---------------- ログイン判定 ----------------
    public function isLoginable(): bool
    {
        $now = Carbon::now();

        /*
    |--------------------------------------------------------------------------
    | 1. 開始前はログイン不可
    |--------------------------------------------------------------------------
    */
        if ($this->start_date && $now->lt(Carbon::parse($this->start_date))) {
            return false;
        }

        /*
    |--------------------------------------------------------------------------
    | 2. 終了日＋1か月まではログイン可
    |--------------------------------------------------------------------------
    */
        if ($this->end_date) {
            $graceEnd = Carbon::parse($this->end_date)->addMonth();

            if ($now->lte($graceEnd)) {
                return true;
            }

            // 猶予期間も過ぎたら不可
            return false;
        }

        /*
    |--------------------------------------------------------------------------
    | 3. 終了日未設定 → 通常ログイン可
    |--------------------------------------------------------------------------
    */
        return true;
    }



    public function scopeLoginVisible($query)
    {
        return $query
            ->where('is_show', 1)
            ->whereNull('deleted_at')
            ->whereIn('status', [self::STATUS_DRAFT, self::STATUS_PUBLISHED]);
    }

    public function loginRemainingDays(): ?int
    {
        // 終了日なし → 制限なし
        if ($this->end_date === null) {
            return null;
        }

        $limitDate = Carbon::parse($this->end_date)
            ->addMonth()
            ->endOfDay();

        // すでに期限切れ
        if (now()->gt($limitDate)) {
            return 0;
        }

        return now()->diffInDays($limitDate);
    }

    public function loginStatusLabel(): array
    {
        if (!$this->isLoginable()) {
            return [
                'icon' => '🔒',
                'text' => 'ログイン不可',
            ];
        }

        $days = $this->loginRemainingDays();

        if ($days === null) {
            return [
                'icon' => '🔓',
                'text' => '常にログイン可',
            ];
        }

        return [
            'icon' => '🔓',
            'text' => "ログイン可（残り{$days}日）",
        ];
    }

    public function getLoginRemainingDaysAttribute(): ?int
    {
        if ($this->end_date === null) {
            return null;
        }

        $endLimit = \Carbon\Carbon::parse($this->end_date)->addMonth()->endOfDay();
        $remaining = now()->diffInDays($endLimit, false); // 過ぎていたらマイナス

        return $remaining > 0 ? $remaining : 0;
    }
}
