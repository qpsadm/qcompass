<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_files', function (Blueprint $table) {

            $table->id()->comment('主キー');
            $table->unsignedBigInteger('agenda_id')->comment('アジェンダID');
            $table->string('file_path', 255)->comment('保存先パス');
            $table->string('file_name', 255)->comment('表示用のファイル名');
            $table->tinyInteger('file_type')->nullable()->comment('ファイル種別');
            $table->string('description', 100)->nullable()->comment('備考・用途');
            $table->integer('file_size')->nullable()->comment('ファイルサイズ（KB）');

            // Laravel 管理
            $table->timestamps();
            $table->softDeletes();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー
            $table->foreign('agenda_id')->references('id')->on('agendas')->onDelete('cascade');

            $table->comment('アジェンダ添付ファイルマスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_files');
    }
};
