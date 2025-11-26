<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_tags', function (Blueprint $table) {
            $table->id(); // 主キー

            $table->foreignId('agenda_id')
                ->constrained('agendas')
                ->onDelete('cascade')
                ->comment('アジェンダID');

            $table->foreignId('tag_id')
                ->constrained('tags')
                ->onDelete('cascade')
                ->comment('タグID');

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
        Schema::dropIfExists('agenda_tags');
    }
};
