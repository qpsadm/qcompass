<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_categorys', function (Blueprint $table) {

            $table->id()->comment('主キー');
            $table->unsignedBigInteger('course_id')->comment('講座ID');
            $table->unsignedBigInteger('category_id')->comment('カテゴリID');
            $table->text('note')->nullable()->comment('備考');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            // Laravel管理
            $table->timestamps();
            $table->softDeletes();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('category_id')->references('id')->on('categories');

            $table->comment('講座カテゴリ紐付けマスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_categorys');
    }
};
