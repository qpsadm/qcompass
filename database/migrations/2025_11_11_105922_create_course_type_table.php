<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('course_types', function (Blueprint $table) {
            $table->id()->comment('主キー');
            $table->foreignId('organizer_id')->constrained('organizers')->comment('実施主体ID');
            $table->string('name', 255)->comment('名前');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            $table->comment('講座分野マスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('course_types');
    }
};
