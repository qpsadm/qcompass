<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_offers', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('company', 255)->nullable();
            $table->string('file_path', 255)->nullable();
            $table->integer('user_id')->nullable();

            $table->timestamps();  // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_offers');
    }
};
