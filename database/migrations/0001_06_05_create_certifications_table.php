<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certifications', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique()->comment('資格名');

            $table->tinyInteger('level')->default(1); // 1:初級, 2:上級

            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_show')->default(true);
            $table->softDeletes(); // deleted_at 用
            $table->timestamps();

            // 作成者・更新者・削除者
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};
