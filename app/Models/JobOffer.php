<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class JobOffer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_offers';

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'start_datetime',
        'end_datetime',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime'   => 'datetime',
        'is_show'        => 'boolean',
    ];

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
