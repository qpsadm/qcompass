<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes; // SoftDeletes トレイトを追加

    // 複数のカラムを一括割り当て可能にする
    protected $fillable = [
        'asker_id', // 質問者ID
        'target_id', // 対象者ID
        'course_id', // 講座ID
        'title', // 質問タイトル
        'responder_id', // 回答者ID（講師）
        'content', // 質問内容
        'answer', // 回答内容
        'is_show', // 公開設定（true/false）
        'tag_id', // タグID
    ];

    // 講座とのリレーション（1対多）
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id'); // 質問は1つの講座に属している
    }

    // 回答者（講師）とのリレーション（1対多）
    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id'); // 質問には1人の回答者（講師）がいる
    }

    // タグとのリレーション（1対多）
    public function tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id'); // 質問には1つのタグがある
    }

    // 質問者（学生）とのリレーション（1対多）
    public function asker()
    {
        return $this->belongsTo(User::class, 'asker_id'); // 質問は1人の学生（質問者）に関連付けられる
    }

    // 対象者（講師）とのリレーション（1対多）
    public function target()
    {
        return $this->belongsTo(User::class, 'target_id'); // 質問は1人のターゲット（講師）に関連付けられる
    }
}
