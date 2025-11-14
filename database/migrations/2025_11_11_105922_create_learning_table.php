<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learnings', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['book', 'site', 'test']);
            $table->string('name', 255);
            $table->string('author', 255)->nullable();
            $table->string('publisher', 255)->nullable();
            $table->date('publication_date')->nullable();
            $table->string('isbn', 20)->nullable();
            $table->string('url', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->nullable();
            $table->text('description')->nullable();

            $table->timestamps(); // created_at / updated_at 自動追加
            $table->softDeletes(); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learnings');
    }
};