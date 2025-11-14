<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('learning_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('learning_id');
            $table->unsignedBigInteger('tag_id');

            $table->timestamps(); // created_at / updated_at 自動追加
            $table->softDeletes(); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('learning_tags');
    }
};
