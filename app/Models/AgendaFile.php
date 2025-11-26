<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgendaFile extends Model
{
    use HasFactory, SoftDeletes; // ← ここがポイント

    protected $fillable = [
        'target_id',
        'target_type',
        'file_path',
        'file_name',
        'file_type',
        'description',
    ];

    protected static function booted()
    {
        static::deleting(function ($agendaFile) {
            if ($agendaFile->file_path && Storage::exists($agendaFile->file_path)) {
                Storage::delete($agendaFile->file_path);
            }
        });
    }

    // Agenda とのリレーション

    public function target()
    {
        return $this->morphTo();
    }
}