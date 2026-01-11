<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\Organizer;

class CourseType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'organizer_id',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Model Events（作成者・更新者・削除者）
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        // 作成時
        static::creating(function ($model) {
            $userName = Auth::user()->name ?? 'system';

            $model->created_user_name = $model->created_user_name ?? $userName;
            $model->updated_user_name = $model->updated_user_name ?? $userName;
        });

        // 更新時
        static::updating(function ($model) {
            $model->updated_user_name = Auth::user()->name ?? 'system';
        });

        // 論理削除時
        static::deleting(function ($model) {
            $model->deleted_user_name = Auth::user()->name ?? 'system';
            $model->saveQuietly(); // ← 必須（無限ループ防止）
        });
    }
}
