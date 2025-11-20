<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id()->comment('主キー');
            $table->string('code', 50)->unique()->comment('レベルコード');
            $table->string('name', 255)->comment('名前');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');
            // Laravel自動管理
            $table->timestamps(); // created_at / updated_at
            $table->softDeletes(); // deleted_at

            // 追加のユーザー情報
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');
            $table->comment('講座レベルマスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
