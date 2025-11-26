<?php

// 不要になった　2025-11-25

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_tags', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('learning_id');
            $table->unsignedBigInteger('tag_id');

            // Laravel自動管理
            $table->timestamps(); // created_at / updated_at
            $table->softDeletes(); // deleted_at

            // 追加のユーザー情報
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');


            $table->foreign('learning_id')
                ->references('id')->on('learnings')
                ->onDelete('cascade');
            $table->foreign('tag_id')
                ->references('id')->on('tags')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_tags');
    }
};
