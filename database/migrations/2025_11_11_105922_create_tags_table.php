<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('name', 100);
            $table->enum('tag_type', ['agenda', 'course', 'book', 'resume', 'job', 'qualification', 'learning_site', 'custom']);
            $table->enum('theme_color', ['red', 'blue', 'green', 'yellow'])->nullable();
            $table->string('description', 255)->nullable();

            $table->timestamps();      // created_at, updated_at 自動生成
            $table->softDeletes();     // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
