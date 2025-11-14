<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_tags', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('agenda_id');
            $table->foreignId('tag_id');
            $table->softDeletes(); // deleted_at
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_tags');
    }
};
