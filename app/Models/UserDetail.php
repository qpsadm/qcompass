<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        'avatar_path',
        'theme_color',
        'status',
        'is_show',
        'divisions_id',
        'bio',
        'memo1',
        'memo2',
        'joining_date',
        'leaving_date',
        'leaving_reason',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    protected $casts = [
        'gender'        => 'integer',
        'status'        => 'integer',
        'theme_color'   => 'integer',
        'is_show'       => 'boolean',
        'joining_date'  => 'date',
        'leaving_date'  => 'date',
        'deleted_at'    => 'datetime',
        'birthday'      => 'date',
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
            $model->saveQuietly(); // SoftDelete時の無限ループ防止
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

    // テーマ
    public function theme()
    {
        return $this->belongsTo(\App\Models\Theme::class, 'theme_id');
    }
}
