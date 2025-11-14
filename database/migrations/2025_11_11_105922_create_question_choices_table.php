<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('question_choices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->text('choice_text');
            $table->boolean('is_correct');
            $table->integer('order')->nullable();

            $table->timestamps();   // created_at / updated_at 自動追加
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_choices');
    }
};
