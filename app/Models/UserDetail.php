<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'birthday',
        'gender',       // INT型
        'phone1',
        'phone2',
        'postal_code',
        'address1',
        'address2',
        'emergency_contact',
        'avatar_path',
        'theme_color',  // INT型
        'status',       // INT型
        'is_show',
        'divisions_id',
        'bio',
        'memo1',
        'memo2',
        'joining_date',
        'leaving_date',
        'leaving_reason',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    protected $casts = [
        'gender' => 'integer',
        'status' => 'integer',
        'theme_color' => 'integer',
        'is_show' => 'boolean',
        'joining_date' => 'date',
        'leaving_date' => 'date',
        'deleted_at' => 'datetime',
        'birthday' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function division()
    {
        return $this->belongsTo(Division::class, 'divisions_id');
    }
}
