<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class QuotePart extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quote_id',
        'part_type',
        'text',
        'weight',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function quote()
    {
        return $this->belongsTo(Quote::class);
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
