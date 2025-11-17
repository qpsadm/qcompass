<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code', 'title', 'description', 'course_id', 'agenda_id', 'type', 'time_limit', 'total_score', 'passing_score', 'random_order', 'active_from', 'active_to', 'created_by', 'deleted_at'];
    protected $casts = [
        'type' => 'integer',         // INT型に対応
        'random_order' => 'boolean',
        'active_from' => 'datetime',
        'active_to' => 'datetime',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
