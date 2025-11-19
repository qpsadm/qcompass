<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {

            $table->id()->comment('主キー');
            $table->string('title', 255)->comment('求人票のタイトル');
            $table->string('description', 512)->nullable()->comment('説明文');
            $table->string('file_path', 255)->nullable()->comment('PDFファイル保存パス');
            $table->timestamp('start_datetime')->nullable()->comment('表示開始日時');
            $table->timestamp('end_datetime')->nullable()->comment('表示終了日時');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            // Laravel 管理
            $table->timestamps();

            // 作成者・更新者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');

            $table->comment('求人表マスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
