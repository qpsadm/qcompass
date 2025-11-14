<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyQuote extends Model
{
    use HasFactory;

    protected $fillable = ['quote', 'author', 'display_date', 'is_show', 'deleted_at'];
}