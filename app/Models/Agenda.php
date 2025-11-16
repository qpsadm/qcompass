<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['agenda_name', 'category_id', 'description', 'is_show', 'user_id', 'accept', 'created_user_id', 'updated_user_id', 'deleted_at', 'deleted_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
}
