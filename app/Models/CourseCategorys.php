<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategorys extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'category_id', 'note', 'is_show'];
}
