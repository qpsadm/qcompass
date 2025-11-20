<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    // タイムスタンプ無効化
    public $timestamps = false;

    // 保存可能なカラム
    protected $fillable = ['code', 'name', 'is_show'];

    // キャストを指定してbooleanとして扱う
    protected $casts = [
        'is_show' => 'boolean',
    ];
}
