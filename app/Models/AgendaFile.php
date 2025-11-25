<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AgendaFile extends Model
{
    protected $fillable = ['agenda_id', 'file_path', 'file_name', 'file_type', 'description'];

    protected static function booted()
    {
        static::deleting(function ($agendaFile) {
            if ($agendaFile->file_path && Storage::exists($agendaFile->file_path)) {
                Storage::delete($agendaFile->file_path);
            }
        });
    }

    // Agenda とのリレーション
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }
}