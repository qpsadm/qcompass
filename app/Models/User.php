<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // public function toSearchableArray()
    // {
    //     return [
    //         'id' => $this->id,
    //         'code' => $this->code,
    //         'name' => $this->name,
    //         'furigana' => $this->furigana,
    //     ];
    // }

    protected $fillable = [
        'code',
        'name',
        'furigana',
        'roman_name',
        'password',
        'role_id',
        'courses_id',
        'remember_token',
        'email',
        'email_verified_at',
        'created_user_id',
        'updated_user_id',
        'deleted_at',
        'deleted_user_id',
    ];

    public function detail()
    {
        return $this->hasOne(UserDetail::class, 'user_id');

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id', 'course_id');
    }
}