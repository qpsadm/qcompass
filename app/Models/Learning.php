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
        'image',
        'url',
        'level',
        'is_show',
        'tag_id',
    ];

    /**
     * JSON / Blade で使うアクセサを自動追加
     */
    protected $appends = [
        'type_label',
        'is_visible',
    ];

    /**
     * タグとのリレーション
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * 種類ラベル（一覧表示用）
     * $learning->type_label
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'book'    => '本',
            'site'    => 'サイト',
            'video'   => '動画',
            'article' => '記事',
            default   => '-',
        };
    }

    /**
     * 表示フラグ
     * $learning->is_visible
     */
    public function getIsVisibleAttribute(): bool
    {
        return (bool) $this->is_show;
    }
}
