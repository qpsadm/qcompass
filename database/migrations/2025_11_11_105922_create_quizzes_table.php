<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->bigInteger('course_id')->nullable();
            $table->bigInteger('agenda_id')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1=exam, 2=survey, 3=practice');

            $table->integer('time_limit')->nullable();
            $table->integer('total_score')->nullable();
            $table->integer('passing_score')->nullable();
            $table->boolean('random_order')->default(false);
            $table->timestamp('active_from')->nullable();
            $table->timestamp('active_to')->nullable();
            $table->integer('created_by');
            $table->timestamp('deleted_at')->nullable();

            // ここで自動的に created_at と updated_at が作られる
            $table->timestamps();
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')
                ->constrained('quizzes')
            ;

            $table->text('question_text'); // 問題文
            $table->integer('score')->default(0); // 点数
            $table->boolean('is_show')->default(true); // 公開するか
            $table->string('type')->default('single'); // single / multi / text / single_2 / single_4 等

            $table->integer('order')->default(0); // 並び順
            // Laravel自動管理
            $table->timestamps(); // created_at / updated_at
            $table->softDeletes(); // deleted_at

            // 追加のユーザー情報
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('quiz_questions');
    }
};
