<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('code', 50)->unique();
            $table->string('name', 255);
            $table->foreignId('parent_id')->nullable();
            $table->foreignId('top_id')->nullable();
            $table->integer('level')->default(1);
            $table->integer('child_count')->default(0);
            $table->boolean('is_show')->default(true);
            $table->tinyInteger('theme_color')->default(1); // 1:red, 2:blue, 3:green

            $table->softDeletes(); // deleted_at
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
