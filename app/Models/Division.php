<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use SoftDeletes;

    public $timestamps = false;  // ←これ必須！

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
