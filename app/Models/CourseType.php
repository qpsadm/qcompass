<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organizer;

class CourseType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'organizer_id', 'is_show'];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public $timestamps = false;
}
