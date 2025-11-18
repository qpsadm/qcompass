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

    public function authorParts()
    {
        return $this->hasMany(AuthorPart::class);
    }
    public function getQuoteFullAttribute()
    {
        return $this->quoteParts->pluck('text')->implode('');
    }

    public function getAuthorFullAttribute()
    {
        return $this->authorParts->pluck('text')->implode('');
    }
}
