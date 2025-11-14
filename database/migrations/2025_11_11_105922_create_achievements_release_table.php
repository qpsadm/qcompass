<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements_release', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('user_id')->nullable(); // ユーザーID
            $table->foreignId('achievement_master_id')->nullable(); // 実績マスタID
            $table->timestamp('unlocked_at')->nullable();
            $table->text('condition_met')->nullable();
            $table->timestamps(); // created_at, updated_at 自動追加
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements_release');
    }
};
