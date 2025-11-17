<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_files', function (Blueprint $table) {
            $table->id(); // 主キー
            $table->foreignId('agenda_id')->default(0);
            $table->string('file_path', 255);
            $table->string('file_name', 255);
            $table->tinyInteger('file_type'); // 0: pdf, 1: docx, 2: xlsx, 3: jpg, 4: png, 5: pptx, 6: zip, 7: other

            $table->string('description', 255);
            $table->integer('file_size')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->softDeletes(); // deleted_at
            $table->timestamps();  // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_files');
    }
};
