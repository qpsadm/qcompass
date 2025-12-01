<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = ['quote_full', 'author_full', 'is_show'];

    // 名言パーツ
    public function quoteParts()
    {
        return $this->hasMany(QuotePart::class, 'quote_id', 'id');
    }

    // 作者パーツ
    public function authorParts()
    {
        return $this->hasMany(AuthorPart::class, 'quote_id', 'id');
    }

    // アクセサや parts() は削除
}
