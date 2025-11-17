<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50);
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->bigInteger('course_id')->nullable();
            $table->bigInteger('agenda_id')->nullable();
            $table->tinyInteger('type')->default(1)->comment('1=exam, 2=survey, 3=practice');

            $table->integer('time_limit')->nullable();
            $table->integer('total_score')->nullable();
            $table->integer('passing_score')->nullable();
            $table->boolean('random_order')->default(false);
            $table->timestamp('active_from')->nullable();
            $table->timestamp('active_to')->nullable();
            $table->integer('created_by');
            $table->timestamp('deleted_at')->nullable();

            // ここで自動的に created_at と updated_at が作られる
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
