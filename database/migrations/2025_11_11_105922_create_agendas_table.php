<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->string('agenda_name', 255);
            $table->foreignId('category_id')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_show')->default(true);
            $table->foreignId('user_id')->nullable();
            $table->enum('accept', ['yes', 'no']);
            $table->foreignId('created_user_id')->nullable();
            $table->foreignId('updated_user_id')->nullable();
            $table->softDeletes(); // deleted_at
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
