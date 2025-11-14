<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_statistics', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quiz_id');
            $table->float('average_score')->nullable();
            $table->integer('highest_score')->nullable();
            $table->integer('attempts_count')->nullable();

            $table->timestamps(); // created_at と updated_at 自動生成
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_statistics');
    }
};
