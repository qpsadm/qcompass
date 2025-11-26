<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_quotes', function (Blueprint $table) {

            $table->id();

            $table->string('quote', 255);
            $table->string('author', 255);
            $table->date('display_date')->nullable();
            $table->boolean('is_show')->default(true);

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
        Schema::dropIfExists('daily_quotes');
    }
};
