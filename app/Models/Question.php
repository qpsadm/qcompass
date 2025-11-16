<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['asker_id', 'agenda_id', 'course_id', 'title', 'responder_id', 'content', 'answer', 'is_show', 'deleted_at'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices()
    {
        return $this->hasMany(QuestionChoice::class)->orderBy('order');
    }
}
