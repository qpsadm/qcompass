<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id()->comment('主キー');
            $table->string('code', 50)->unique()->comment('部署コード');
            $table->string('name', 50)->comment('部署名');
            $table->string('tel', 50)->nullable()->comment('電話番号');
            $table->string('post_code', 7)->nullable()->comment('郵便番号');
            $table->string('address', 255)->nullable()->comment('住所');
            $table->boolean('is_show')->comment('表示可否');
            $table->string('memo', 255)->nullable()->comment('備考');
            $table->timestamps();

            $table->comment('部署マスタ');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};
