<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseTeacher extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'course_id',
        'user_id',
        'role_in_course',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];
}
