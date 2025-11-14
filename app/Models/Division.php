<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'parent_id', 'hierarchy_level', 'child_count', 'is_show', 'created_user_id', 'updated_user_id', 'deleted_at', 'deleted_user_id'];
}