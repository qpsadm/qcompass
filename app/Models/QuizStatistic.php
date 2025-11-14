<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizStatistic extends Model
{
    use HasFactory;

    protected $fillable = ['quiz_id', 'average_score', 'highest_score', 'attempts_count'];
}