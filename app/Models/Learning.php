<?php

// Learning.php

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

    // Tagとのリレーション
    public function tag()
    {
        return $this->belongsTo(Tag::class);  // `tag_id` で `Tag` モデルと関連づけ
    }

    /**
     * Blade 側で $learning->is_visible としてアクセスできるようにする
     */
    public function getIsVisibleAttribute()
    {
        return (bool) $this->is_show;
    }
}