<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('name', 255)->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('hierarchy_level')->default(1);
            $table->integer('child_count')->default(0);
            $table->boolean('is_show')->default(true);

            // ユーザー管理カラム（必要なら）
            $table->integer('created_user_id')->nullable();
            $table->integer('updated_user_id')->nullable();
            $table->integer('deleted_user_id')->nullable();

            $table->timestamps();  // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
