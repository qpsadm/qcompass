<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_quotes', function (Blueprint $table) {
            $table->id();
            $table->text('quote');
            $table->string('author', 255);
            $table->date('display_date')->nullable();
            $table->boolean('is_show')->default(true);

            $table->timestamps();  // created_at, updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_quotes');
    }
};
