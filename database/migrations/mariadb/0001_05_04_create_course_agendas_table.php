<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_agendas', function (Blueprint $table) {

            $table->id(); // 主キー id

            // 外部キー
            $table->foreignId('course_id')
                ->constrained('courses')
                ->onDelete('set null')
                ->comment('コースID');

            $table->foreignId('agenda_id')
                ->constrained('agendas')
                ->onDelete('set null')
                ->comment('アジェンダID');

            $table->integer('order_no');
            $table->string('note', 255)->nullable();

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
        Schema::dropIfExists('course_agendas');
    }
};
