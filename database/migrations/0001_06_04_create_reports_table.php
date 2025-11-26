<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {

            $table->id()->comment('主キー');

            $table->unsignedBigInteger('user_id')->comment('提出者ID');

            $table->unsignedBigInteger('course_id')->comment('講座ID');

            $table->date('date')->comment('日報対象日');
            $table->string('title', 100)->comment('タイトル');

            $table->text('content')->comment('日報');

            $table->text('impression')->comment('感想・気付き・質問');

            $table->text('notice')->nullable()->comment('連絡事項');

            // Laravel管理
            $table->timestamps();
            $table->softDeletes();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');

            // 外部キー
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('restrict');

            $table->comment('日報マスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
