<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id()->comment('主キー');
            $table->string('code', 50)->comment('テーマコード');
            $table->string('name', 100)->comment('テーマ名');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            $table->comment('テーママスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
