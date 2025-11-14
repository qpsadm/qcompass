<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'title', 'description', 'course_id', 'agenda_id', 'type', 'time_limit', 'total_score', 'passing_score', 'random_order', 'active_from', 'active_to', 'created_by', 'deleted_at'];
}