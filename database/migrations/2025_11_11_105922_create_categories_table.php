<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {

            $table->id()->comment('主キー');
            $table->string('code', 50)->unique()->comment('カテゴリーコード');
            $table->string('name', 255)->comment('カテゴリー名');
            $table->unsignedBigInteger('parent_id')->nullable()->comment('親ID');
            $table->unsignedBigInteger('top_id')->nullable()->comment('最上位ID');
            $table->integer('level')->default(1)->comment('階層');
            $table->integer('child_count')->default(0)->comment('子数');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            // Laravel管理
            $table->timestamps();      // created_at / updated_at
            $table->softDeletes();     // deleted_at

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            $table->comment('カテゴリー（課目）マスタ');

            // 親カテゴリーの外部キー（任意）
            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
