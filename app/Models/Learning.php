<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning extends Model
{
    use HasFactory;

    protected $fillable = ['type', 'name', 'author', 'publisher', 'publication_date', 'isbn', 'url', 'image', 'level', 'description', 'deleted_at'];
}