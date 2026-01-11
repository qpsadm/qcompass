<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Illuminate\Support\Facades\Auth;

class Agenda extends Model
{
    use HasFactory, SoftDeletes, Searchable;

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
        'deleted_user_name',
    ];

    protected $casts = [
        'is_show' => 'boolean',
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function files()
    {
        return $this->morphMany(AgendaFile::class, 'target')
            ->whereNull('deleted_at');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_agendas', 'agenda_id', 'course_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */
    public function getCourseAttribute()
    {
        return $this->category ? $this->category->course : null;
    }

    /*
    |--------------------------------------------------------------------------
    | Scout
    |--------------------------------------------------------------------------
    */
    public function toSearchableArray()
    {
        return [
            'agenda_name' => $this->agenda_name,
            'content' => $this->content,
        ];
    }
}
