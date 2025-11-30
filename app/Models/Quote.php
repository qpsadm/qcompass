<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = ['quote_full', 'author_full', 'is_show'];

    public function quoteParts()
    {
        return $this->hasMany(QuotePart::class);
    }

    // author_parts テーブルのリレーション
    public function authorParts()
    {
        return $this->hasMany(AuthorPart::class, 'quote_id', 'id');
    }

    public function getQuoteFullAttribute()
    {
        return $this->quoteParts->pluck('text')->implode('');
    }

    public function getAuthorFullAttribute()
    {
        return $this->authorParts->pluck('text')->implode('');
    }

    // quote_parts テーブルのリレーション
    public function parts()
    {
        return $this->hasMany(QuotePart::class, 'quote_id', 'id');
    }
}
