<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('count')->default('1000');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files_counts');
    }
};
