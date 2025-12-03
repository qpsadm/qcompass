<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quote_full',
        'author_full',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    public function quoteParts()
    {
        return $this->hasMany(QuotePart::class, 'quote_id');
    }

    public function authorParts()
    {
        return $this->hasMany(AuthorPart::class, 'quote_id');
    }
}
