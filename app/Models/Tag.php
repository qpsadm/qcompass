<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'tag_type',      // INT 型
        'theme_color',   // INT 型
        'description',
        'deleted_at'
    ];

    protected $casts = [
        'tag_type' => 'integer',
        'theme_color' => 'integer',
        'deleted_at' => 'datetime',
    ];
}
