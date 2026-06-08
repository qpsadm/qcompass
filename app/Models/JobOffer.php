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

    /**
     * 保存可能カラム
     */
    protected $fillable = [
        'title',
        'description',
        'file_path1',
        'file_path2',
        'file_path3',
        'file_path4',
        'file_path5',
        'start_datetime',
        'end_datetime',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    /**
     * 型キャスト
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime'   => 'datetime',
        'is_show'        => 'boolean',
    ];

    /**
     * モデルイベント
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

        // 削除時（論理削除）
        static::deleting(function ($model) {
            $model->deleted_user_name = Auth::user()->name ?? 'system';
            $model->saveQuietly(); // 無限ループ防止
        });
    }

    /**
     * ファイルパスを配列で取得するアクセサ
     */
    public function getFilePathsAttribute()
    {
        return array_filter([
            $this->file_path1,
            $this->file_path2,
            $this->file_path3,
            $this->file_path4,
            $this->file_path5,
        ]);
    }
}