<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_id')->nullable()->comment('対象レコードID');
            $table->string('target_type')->comment('対象モデルクラス名');
            $table->string('file_path', 255)->comment('保存先パス');
            $table->string('file_name', 255)->comment('表示用のファイル名');
            $table->string('file_type', 100)->nullable()->comment('ファイル種別');
            $table->string('description', 100)->nullable()->comment('備考・用途');
            $table->integer('file_size')->nullable()->comment('ファイルサイズ（バイト）');
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_user_name', 50)->nullable();
            $table->string('updated_user_name', 50)->nullable();
            $table->string('deleted_user_name', 50)->nullable();

            $table->comment('アジェンダ・お知らせ添付ファイル');

            // ← polymorphic なので外部キーは付けない
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_files');
    }
};
