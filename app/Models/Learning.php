<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Learning extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'title',
        'description',
        'image',        // 画像パス
        'url',
        'level',
        'is_show',
        'tag_id',
        'course_name',  // 訓練科名
        'priod',        // 制作期間
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
            $model->saveQuietly(); // ← 無限ループ防止
        });
    }

    protected $appends = [
        'type_label',
        'is_visible',
    ];

    // タグリレーション
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    // 種類ラベル
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            // 'book' => '本',
            // 'site' => 'サイト',
            // 'video' => '動画',
            // 'article' => '記事',
            // 'other' => 'その他',
            '1' => '参考書籍',
            '2' => '参考サイト',
            '3' => 'IT資格',
            '4' => '制作品',
            // default => '-',
        };
    }

    // 表示フラグ
    public function getIsVisibleAttribute(): bool
    {
        return (bool) $this->is_show;
    }

    public function getVisibleLabelAttribute(): string
    {
        return $this->is_visible ? '表示' : '非表示';
    }
}