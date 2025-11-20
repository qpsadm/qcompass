<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnnouncementType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type_name',
        'is_show',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'type_id');
    }
}
