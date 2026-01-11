<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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

    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        // 作成時
        static::creating(function ($model) {
            if (Auth::check()) {
                $name = Auth::user()->name;
                $model->created_user_name = $name;
                $model->updated_user_name = $name;
            }
        });

        // 更新時
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_user_name = Auth::user()->name;
            }
        });

        // 削除時（SoftDelete）
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
    public function type()
    {
        return $this->belongsTo(AnnouncementType::class, 'type_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // ※このリレーションは用途次第。不要なら削除推奨
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'type_id');
    }

    public function files()
    {
        return $this->morphMany(AgendaFile::class, 'target')
            ->whereNull('deleted_at');
    }
}
