<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('quiz_id');
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->integer('score')->nullable();
            $table->tinyInteger('status')->comment('1=in_progress, 2=completed, 3=graded');

            $table->integer('attempt_no');
            $table->string('ip_address', 100)->nullable();

            $table->timestamps(); // created_at と updated_at 自動生成
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
