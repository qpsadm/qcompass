<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_category', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('course_id');
            $table->foreignId('category_id');
            $table->text('note')->nullable();
            $table->boolean('is_show')->default(true);
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_category');
    }
};
