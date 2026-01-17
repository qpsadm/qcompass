<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    ];

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
            'book' => '本',
            'site' => 'サイト',
            'video' => '動画',
            'article' => '記事',
            'other' => 'その他',
            default => '-',
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
