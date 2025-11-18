<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_full')->comment('原文の名言');
            $table->string('author_full')->nullable()->comment('原文の作者');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('quote_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes')->onDelete('cascade');
            $table->string('part_type', 1)->comment('A/B/C パーツ分類');
            $table->string('text')->comment('名言パーツ本文');
            $table->unsignedTinyInteger('weight')->default(100)->comment('出現率');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('author_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quote_id')->constrained('quotes')->onDelete('cascade');
            $table->string('part_type', 1)->comment('A/B/C パーツ分類'); // B → ABC に変更
            $table->string('text')->comment('作者パーツ');
            $table->unsignedTinyInteger('weight')->default(100)->comment('出現率');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
        Schema::dropIfExists('quote_parts');
        Schema::dropIfExists('author_parts');
    }
};
