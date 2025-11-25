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
        'author',
        'publisher',
        'publication_date',
        'isbn',
        'url',
        'image',
        'level',
        'description',
        'is_show'
    ];

    /**
     * Blade 側で $learning->is_visible としてアクセスできるようにする
     */
    public function getIsVisibleAttribute()
    {
        return (bool) $this->is_show;
    }
}
