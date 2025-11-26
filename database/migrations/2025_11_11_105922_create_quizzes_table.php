<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // -------------------------
        // quizzesテーブル作成
        // -------------------------
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id()->comment('主キーID');
            $table->string('code', 50)->comment('クイズコード');
            $table->string('title', 255)->comment('クイズタイトル');
            $table->text('description')->nullable()->comment('クイズの説明文');
            $table->bigInteger('course_id')->nullable()->comment('紐づくコースID');
            $table->bigInteger('target_id')->nullable()->comment('紐づくアジェンダID');
            $table->tinyInteger('type')->default(1)->comment('クイズ種類 1=exam,2=survey,3=practice');

            $table->integer('time_limit')->nullable()->comment('制限時間（分）');
            $table->integer('total_score')->nullable()->comment('満点');
            $table->integer('passing_score')->nullable()->comment('合格点');
            $table->boolean('random_order')->default(false)->comment('問題のランダム出題フラグ');
            $table->timestamp('active_from')->nullable()->comment('公開開始日時');
            $table->timestamp('active_to')->nullable()->comment('公開終了日時');
            $table->integer('created_by')->comment('作成者ユーザーID');

            // 自動管理
            $table->timestamps(); // created_at / updated_at
            $table->softDeletes(); // deleted_at (ソフトデリート対応)
        });


        // -------------------------
        // quiz_questionsテーブル作成
        // -------------------------
        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id()->comment('主キーID');
            $table->foreignId('quiz_id')->constrained('quizzes')->comment('紐づくクイズID');

            $table->text('question_text')->comment('問題文');
            $table->integer('score')->default(0)->comment('問題の配点');
            $table->boolean('is_show')->default(true)->comment('公開するかどうか');
            $table->string('type')->default('single')->comment('問題タイプ single/multi/textなど');
            $table->integer('order')->default(0)->comment('並び順');

            $table->timestamps();
            $table->softDeletes();

            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quizzes');
    }
};
