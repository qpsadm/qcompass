<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgendaFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'target_id',
        'target_type',
        'file_path',
        'file_name',
        'file_type',
        'description',
        'file_size',
        'created_user_name',
        'updated_user_name',
        'deleted_user_name',
    ];

    protected static function booted()
    {
        // 作成時
        static::creating(function ($model) {
            if (Auth::check()) {
                $name = Auth::user()->name;
                $model->created_user_name = $name;
                $model->updated_user_name = $name;
            }
        });

        // 更新時
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_user_name = Auth::user()->name;
            }
        });

        // 削除時（SoftDelete）
        static::deleting(function ($agendaFile) {
            // 削除者名を保存
            if (Auth::check()) {
                $agendaFile->deleted_user_name = Auth::user()->name;
                $agendaFile->saveQuietly(); // イベント再発火防止
            }

            // ファイル削除
            if ($agendaFile->file_path && Storage::exists($agendaFile->file_path)) {
                Storage::delete($agendaFile->file_path);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function target()
    {
        return $this->morphTo();
    }
}
