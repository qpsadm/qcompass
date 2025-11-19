<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id()->comment('主キー');
            $table->string('code', 50)->comment('タグコード');
            $table->string('name', 100)->comment('タグ名');
            $table->boolean('is_show')->default(true)->comment('表示フラグ');

            $table->comment('タグマスタ');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
