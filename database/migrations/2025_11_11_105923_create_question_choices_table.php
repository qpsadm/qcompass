<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_question_choices', function (Blueprint $table) {
            $table->id();

            // $table->foreignId('quiz_question_id')
            //     ->constrained('quiz_questions');

            $table->unsignedBigInteger('quiz_question_id')->nullable()->default(null);

            $table->text('choice_text');
            $table->boolean('is_correct')->default(false);
            $table->integer('order')->default(0);
            // Laravel自動管理
            $table->timestamps(); // created_at / updated_at
            $table->softDeletes(); // deleted_at

            // 追加のユーザー情報
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー
            $table->foreign('quiz_question_id')->references('id')->on('quiz_questions')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_question_choices');
    }
};
