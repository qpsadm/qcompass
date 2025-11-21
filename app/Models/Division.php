<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'tel',
        'post_code',
        'address',
        'is_show',
        'memo',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];
}
