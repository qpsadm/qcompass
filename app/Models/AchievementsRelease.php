<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchievementsRelease extends Model
{
    use HasFactory;

    protected $table = 'achievement_releases';

    protected $fillable = [
        'user_id',
        'achievement_master_id',
        'unlocked_at',
        'condition_met',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'achievement_master_id');
    }
}
