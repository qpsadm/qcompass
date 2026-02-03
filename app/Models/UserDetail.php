<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Theme;

class UserDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'birthday',
        'gender',
        'phone1',
        'phone2',
        'postal_code',
        'address1',
        'address2',
        'emergency_contact',

        // アバター
        'avatar_path', // 管理画面用（アップロード画像）
        'avatar_type', // ユーザー画面用（1:default, 2:pattern1, 3:pattern2）

        // UI設定
        'theme_id',
        'fontsize',

        // 状態・プロフィール
        'status',
        'bio',
        'note',
        'memo',

        // 在籍情報
        'joining_date',
        'leaving_date',
        'leaving_reason',

        // 管理情報
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    protected $casts = [
        'gender'        => 'integer',
        'status'        => 'integer',
        'avatar_type'   => 'integer',
        'theme_id'      => 'integer',
        'fontsize'      => 'integer',
        'birthday'      => 'date',
        'joining_date'  => 'date',
        'leaving_date'  => 'date',
        'deleted_at'    => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Model Events（作成者・更新者・削除者 自動設定）
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
            $model->saveQuietly(); // SoftDelete 無限ループ防止
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

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public function getAvatarTypeLabelAttribute()
    {
        return [
            1 => 'デフォルト',
            2 => 'パターン1',
            3 => 'パターン2',
        ][$this->avatar_type] ?? '未設定';
    }

    public function getAvatarTypeImageAttribute()
    {
        return match ($this->avatar_type) {
            2 => asset('assets\images\f_profile_image2.svg'),
            3 => asset('assets\images\f_profile_image3.svg'),
            4 => asset('assets\images\f_profile_image4.svg'),
            5 => asset('assets\images\f_profile_image5.svg'),
            6 => asset('assets\images\f_profile_image6.svg'),
            default => asset('assets\images\f_profile_image1.svg'),
        };
    }
}
