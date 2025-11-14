<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attempt_id');
            $table->bigInteger('question_id');
            $table->bigInteger('choice_id')->nullable();
            $table->text('answer_text')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->integer('score')->nullable();

            $table->timestamps(); // created_at, updated_at 自動生成
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
    }
};
