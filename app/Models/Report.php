<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'course_id', 'date', 'title', 'content', 'impression', 'notice', 'created_user_id', 'updated_user_id', 'deleted_at', 'deleted_user_id'];
}