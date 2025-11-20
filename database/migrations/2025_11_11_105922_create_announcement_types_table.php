<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_types', function (Blueprint $table) {
            $table->id()->comment('主キー');
            $table->string('type_name', 255)->comment('種別名');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            $table->comment('お知らせ分類マスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_types');
    }
};
