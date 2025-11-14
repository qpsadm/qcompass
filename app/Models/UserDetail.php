<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'birthday', 'gender', 'phone1', 'phone2', 'postal_code', 'address1', 'address2', 'emergency_contact', 'avatar_path', 'theme_color', 'status', 'is_show', 'divisions_id', 'bio', 'memo1', 'memo2', 'joining_date', 'leaving_date', 'leaving_reason', 'created_user_id', 'updated_user_id', 'deleted_at', 'deleted_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}