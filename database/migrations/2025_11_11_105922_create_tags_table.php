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
            $table->tinyInteger('tag_type'); // 0: agenda, 1: course, 2: book, 3: resume, 4: job, 5: qualification, 6: learning_site, 7: custom
            $table->tinyInteger('theme_color')->nullable(); // 0: red, 1: blue, 2: green, 3: yellow

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
