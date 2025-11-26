<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievement_releases', function (Blueprint $table) {
            $table->id(); // 主キー

            $table->unsignedBigInteger('user_id')->nullable(); // ユーザーID
            // $table->foreignId('user_id')->nullable(); // ユーザーID

            $table->unsignedBigInteger('achievement_master_id')->nullable(); // 実績マスタID
            // $table->foreignId('achievement_master_id')->nullable(); // 実績マスタID

            $table->timestamp('unlocked_at')->nullable();
            $table->text('condition_met')->nullable();
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
        Schema::dropIfExists('achievement_releases');
    }
};
