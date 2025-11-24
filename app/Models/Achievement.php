<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use SoftDeletes;

    protected $table = 'achievements';
    protected $fillable = [
        'title',
        'description',
        'condition_type',
        'condition_value',
    ];

    public function releases()
    {
        return $this->hasMany(AchievementRelease::class, 'achievement_master_id');
    }
}
