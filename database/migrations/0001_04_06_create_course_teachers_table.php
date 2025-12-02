<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_teachers', function (Blueprint $table) {

            $table->id()->comment('主キー');

            $table->unsignedBigInteger('course_id')->nullable()->comment('講座ID');
            $table->unsignedBigInteger('user_id')->nullable()->comment('講師のユーザーID');

            $table->tinyInteger('role_in_course')->nullable()->comment('担当区分');

            // Laravel 管理
            $table->timestamps();      // created_at / updated_at
            $table->softDeletes();     // deleted_at

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キーの制約
            $table->foreign('course_id')
                ->references('id')->on('courses')
                ->onDelete('set null');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('set null');

            // 複合ユニーク制約
            $table->unique(['course_id', 'user_id']);

            $table->comment('講座講師マスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_teachers');
    }
};
