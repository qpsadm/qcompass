<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
        });
        // 初期データ挿入
        DB::table('organizers')->insert([
            ['id' => 4, 'name' => 'その他',],
            ['id' => 3, 'name' => 'QLIPプログラミングスクール',],
            ['id' => 2, 'name' => '徳島県立テクノスクール',],
            ['id' => 1, 'name' => 'ポリテクセンター徳島',],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('organizers');
    }
};
