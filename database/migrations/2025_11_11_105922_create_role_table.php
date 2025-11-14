<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('role_id')->unique(); // 0,1,5,6,7,9
            $table->string('role_name', 50);         // 管理人、事務、講師など
            $table->timestamps();
        });

        // 初期データ挿入
        DB::table('roles')->insert([
            ['role_id' => 9, 'role_name' => '管理人', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 7, 'role_name' => '事務', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 6, 'role_name' => '講師', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 5, 'role_name' => '臨時講師', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 1, 'role_name' => '生徒', 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 0, 'role_name' => 'ログイン不可', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
