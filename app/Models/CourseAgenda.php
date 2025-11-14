<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseAgenda extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'agenda_id', 'order_no', 'note', 'deleted_at'];
}