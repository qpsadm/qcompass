<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Certification extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'certifications';

    protected $fillable = [
        'name',
        'level',
        'description',
        'url',
        'is_show',
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
}
