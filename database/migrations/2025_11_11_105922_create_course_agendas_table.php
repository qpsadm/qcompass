<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_agendas', function (Blueprint $table) {
            $table->id(); // 主キー id
            $table->foreignId('course_id');
            $table->foreignId('agenda_id');
            $table->integer('order_no');
            $table->string('note', 255)->nullable(); // varchar → string に修正
            $table->softDeletes(); // deleted_at
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_agendas');
    }
};
