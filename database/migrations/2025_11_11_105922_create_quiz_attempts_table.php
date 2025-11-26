<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('quiz_id');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->integer('score')->nullable();
            $table->tinyInteger('status')->comment('1=in_progress, 2=completed, 3=graded');

            $table->integer('attempt_no');
            $table->string('ip_address', 100)->nullable();

            // **追加：正解数を保存**
            $table->integer('total_correct')->default(0)->comment('正解数');

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
        Schema::dropIfExists('quiz_attempts');
    }
};
