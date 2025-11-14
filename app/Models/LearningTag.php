<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningTag extends Model
{
    use HasFactory;

    protected $fillable = ['learning_id', 'tag_id', 'deleted_at'];
}