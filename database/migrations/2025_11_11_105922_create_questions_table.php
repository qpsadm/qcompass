<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asker_id');
            $table->bigInteger('agenda_id')->nullable();
            $table->bigInteger('course_id')->nullable();
            $table->string('title', 255); // varchar → string
            $table->bigInteger('responder_id');
            $table->text('content');
            $table->text('answer');
            $table->boolean('is_show')->default(true);

            $table->timestamps();    // created_at, updated_at
            $table->softDeletes();   // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
