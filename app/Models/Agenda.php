<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agenda extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'agendas';

    protected $fillable = [
        'agenda_name',
        'category_id',
        'description',
        'is_show',
        'user_id',
        'accept',
        'created_user_id',
        'updated_user_id',
    ];

    protected $casts = [
        'is_show' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function createdUser()
    {
        return $this->belongsTo(User::class, 'created_user_id');
    }

    public function updatedUser()
    {
        return $this->belongsTo(User::class, 'updated_user_id');
    }
    public function files()
    {
        return $this->hasMany(AgendaFile::class);
    }
    // 講座との多対多
    public function courses()
    {
        return $this->belongsToMany(
            Course::class,       // 関連モデル
            'course_agendas',    // 中間テーブル名
            'agenda_id',         // 中間テーブルの自分側キー（Agenda → course_agendas）
            'course_id'          // 中間テーブルの相手側キー（Course）
        )->withPivot('order_no', 'note')
            ->withTimestamps();
    }
}