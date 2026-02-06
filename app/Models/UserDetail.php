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
        'avatar_type', // ユーザー画面用（1:default, 2:pattern1, 3:pattern2...99:custom）
        'user_avatar_path', // ユーザー画面用

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
            4 => 'パターン3',
            5 => 'パターン4',
            6 => 'パターン5',
            7 => 'パターン6',
            8 => 'パターン7',
            9 => 'パターン8',
            10 => 'パターン9',
            11 => 'パターン10',
            12 => 'パターン11',
            13 => 'パターン12',
            14 => 'パターン13',
            15 => 'パターン14',

            99 => 'カスタム',
        ][$this->avatar_type] ?? '未設定';
    }

    public function getAvatarTypeImageAttribute()
    {
        // カスタム画像
        if ($this->avatar_type == 99 && $this->user_avatar_path) {
            return asset('storage/' . $this->user_avatar_path);
        }

        // デフォルト
        return match ((int)$this->avatar_type) {
            2 => asset('assets/images/f_profile_image2.svg'),
            3 => asset('assets/images/f_profile_image3.svg'),
            4 => asset('assets/images/f_profile_image4.svg'),
            5 => asset('assets/images/f_profile_image5.svg'),
            6 => asset('assets/images/f_profile_image6.svg'),
            7 => asset('assets/images/f_profile_image7.svg'),
            8 => asset('assets/images/f_profile_image8.svg'),
            9 => asset('assets/images/f_profile_image9.svg'),
            10 => asset('assets/images/f_profile_image10.svg'),
            11 => asset('assets/images/f_profile_image11.svg'),
            12 => asset('assets/images/f_profile_image12.svg'),
            13 => asset('assets/images/f_profile_image13.svg'),
            14 => asset('assets/images/f_profile_image14.svg'),
            15 => asset('assets/images/f_profile_image15.svg'),
            default => asset('assets/images/f_profile_image1.svg'),
        };
    }
}
