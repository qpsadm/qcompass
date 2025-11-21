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
            $table->string('name');
            $table->tinyInteger('level')->nullable(); // 1:初級, 2:上級
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->boolean('display_flag')->default(1);
            $table->softDeletes(); // deleted_at 用
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('certifications');
    }
};