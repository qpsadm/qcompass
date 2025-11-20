<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'parent_id', 'hierarchy_level', 'child_count', 'is_show', 'created_user_name', 'updated_user_name', 'deleted_at', 'deleted_user_name'];
}
