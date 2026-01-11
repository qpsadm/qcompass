<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'asker_id',        // 質問者ID
        'target_id',       // 対象者ID
        'course_id',       // 講座ID
        'title',           // 質問タイトル
        'responder_id',    // 回答者ID
        'content',         // 質問内容
        'answer',          // 回答内容
        'is_show',         // 公開設定
        'tag_id',          // タグID
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }

    public function asker()
    {
        return $this->belongsTo(User::class, 'asker_id');
    }

    public function target()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events
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
            $model->saveQuietly(); // 無限ループ防止
        });
    }
}
