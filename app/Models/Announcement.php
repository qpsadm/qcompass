<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'type_id',
        'content',
        'course_id',
        'is_show',
        'status',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    public function type()
    {
        return $this->belongsTo(AnnouncementType::class, 'type_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'type_id');
    }
    public function files()
    {
        return $this->morphMany(AgendaFile::class, 'target');
    }