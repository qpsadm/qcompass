<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->enum('condition_type', ['attendance', 'score', 'report', 'custom']);
            $table->string('condition_value', 255)->nullable();
            $table->softDeletes(); // deleted_at
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
