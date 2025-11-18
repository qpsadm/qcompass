<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_question_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_question_id')
                ->constrained('quiz_questions')
                ->onDelete('cascade');

            $table->text('choice_text');
            $table->boolean('is_correct')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_choices');
    }
};
