<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learnings', function (Blueprint $table) {

            $table->id()->comment('主キー');
            $table->tinyInteger('type')->comment('種別');
            $table->string('title', 255)->comment('タイトル');
            $table->text('description')->nullable()->comment('説明');
            $table->string('image', 255)->nullable()->comment('画像');
            $table->string('url', 255)->nullable()->comment('URL');
            $table->string('author', 255)->nullable()->comment('著者名');
            $table->string('publisher', 255)->nullable()->comment('出版社');
            $table->date('publication_date')->nullable()->comment('出版日');
            $table->string('isbn', 20)->nullable()->comment('ISBNコード');
            $table->tinyInteger('level')->nullable()->comment('レベル');
            $table->unsignedBigInteger('tag_id')->nullable()->comment('タグID');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            // Laravel 管理
            $table->timestamps();
            $table->softDeletes();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('set null');

            $table->comment('学習サポートマスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learnings');
    }
};
