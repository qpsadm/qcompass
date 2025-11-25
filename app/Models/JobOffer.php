<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobOffer extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'job_offers'; // テーブル名が conventions に従わない場合

    protected $fillable = [
        'title',          // 求人タイトル
        'description',    // 説明文
        'file_path',      // PDF ファイル保存パス
        'start_datetime', // 表示開始日時
        'end_datetime',   // 表示終了日時
        'is_show',        // 表示フラグ
        'created_user_name',        // 更新者名
        'updated_user_name',
        'deleted_user_name',

    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'is_show' => 'boolean',
    ];
}
