<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {

            $table->id()->comment('主キー');
            $table->string('agenda_name', 255)->comment('アジェンダ名');
            $table->unsignedBigInteger('category_id')->comment('カテゴリID');
            $table->text('content')->nullable()->comment('アジェンダ詳細');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');
            $table->unsignedBigInteger('user_id')->comment('作成者');
            $table->tinyInteger('status')->default(0)->comment('状態');

            // Laravel 管理
            $table->timestamps();
            $table->softDeletes();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');

            $table->comment('アジェンダマスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
