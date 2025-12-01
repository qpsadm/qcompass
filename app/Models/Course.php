<?php

namespace App\Models;

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

    // 状態の定数定義
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_ARCHIVED = 2;

    // ステータス定義
    const STATUS = [
        0 => '開校準備',
        1 => '終了',
        2 => '実地中',
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
}
