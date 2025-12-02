<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {

            $table->id()->comment('主キー');

            $table->unsignedBigInteger('course_id')->nullable()->default(null)->comment('講座ID');

            $table->unsignedBigInteger('responder_id')->nullable()->default(null)->comment('回答者（講師）ID');

            $table->unsignedBigInteger('tag_id')->nullable()->comment('タグID');

            $table->string('title', 255)->comment('質問タイトル');

            $table->string('content', 512)->comment('質問内容');
            $table->text('answer')->nullable()->comment('回答内容');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            // Laravel 管理
            $table->timestamps();
            $table->softDeletes();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('set null');

            $table->foreign('responder_id')->references('id')->on('users')->onDelete('set null');

            // 外部キー
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('set null');

            $table->comment('質問マスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
