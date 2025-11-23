<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {

            $table->id()->comment('主キー');
            $table->string('title', 255)->comment('タイトル');
            $table->unsignedInteger('type_id')->comment('カテゴリID');
            $table->text('content')->nullable()->comment('詳細内容');
            $table->unsignedInteger('course_id')->nullable()->comment('講座ID');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');
            $table->tinyInteger('status')->default(0)->comment('状態');

            // Laravel 管理
            $table->timestamps();
            $table->softDeletes();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー
            $table->foreign('type_id')->references('id')->on('announcement_types');

            $table->foreign('course_id')->references('id')->on('courses');

            $table->comment('お知らせ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
