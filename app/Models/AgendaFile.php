<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaFile extends Model
{
    use HasFactory;

    protected $fillable = ['agenda_id', 'file_path', 'file_name', 'file_type', 'description', 'file_size', 'user_id', 'deleted_at'];
}