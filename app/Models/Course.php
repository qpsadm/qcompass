<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Course extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = ['course_code', 'course_type_ID', 'Level_id', 'organizer_id', 'course_name', 'venue', 'application_date', 'certification_date', 'certification_number', 'start_date', 'end_date', 'total_hours', 'periods', 'start_time', 'finish_time', 'start_viewing', 'finish_viewing', 'plan_path', 'flier_path', 'capacity', 'entering', 'completed', 'description', 'status', 'created_user_name', 'updated_user_name', 'deleted_at', 'deleted_user_name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
    }

    // 状態の定数定義
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_ARCHIVED = 2;

    // ステータス定義
    const STATUS = [
        0 => '下書き',      // Draft
        1 => '準備中',      // Preparing
        2 => '公開',        // Published
        3 => '終了',        // Archived
    ];
    public function agendas()
    {
        return $this->belongsToMany(
            Agenda::class,
            'course_agendas',
            'course_id',
            'agenda_id'
        )->withPivot('order_no', 'note')
            ->withTimestamps();
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'Level_id');
    }

    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'course_type_ID');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'course_categorys', 'course_id', 'category_id')
            ->withPivot(['note', 'is_show'])
            ->withTimestamps();
    }
}
