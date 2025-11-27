<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learnings', function (Blueprint $table) {

            // 主キー
            $table->id()->comment('主キー');

            // 種別 (1:書籍, 2:サイト, 3:資格)
            $table->tinyInteger('type')->comment('種別');

            // タグID (nullable として外部キー)
            $table->unsignedBigInteger('tag_id')->nullable()->comment('タグID');

            // タイトル
            $table->string('title', 255)->comment('タイトル');

            // 説明 (nullable)
            $table->text('description')->nullable()->comment('説明');

            // 画像 (nullable)
            $table->string('image', 255)->nullable()->comment('画像');

            // URL (nullable)
            $table->string('url', 255)->nullable()->comment('URL');

            // レベル (nullable)
            $table->tinyInteger('level')->nullable()->comment('レベル');

            // 表示フラグ
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            // 作成日時、更新日時
            $table->timestamps();

            // 論理削除
            $table->softDeletes();

            // 作成者・更新者・削除者 (nullable)
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー制約を設定
            // `tags` テーブルに外部キー制約を設定し、削除時にタグIDをNULLに設定 (onDelete('set null'))
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('set null')->comment('タグID外部キー');

            // テーブルのコメント
            $table->comment('学習サポートマスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learnings');
    }
};