<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class AnnouncementType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type_name',
        'is_show',
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

        // 保存後処理（既存ロジック）
        static::saved(function ($type) {
            // type が非表示になった場合
            if ((int)$type->is_show === 0) {
                // 紐づくお知らせも非表示に
                $type->announcements()->update(['is_show' => 0]);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'type_id');
    }
}
