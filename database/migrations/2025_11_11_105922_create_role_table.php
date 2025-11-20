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
            $table->string('role_name', 50);         // 管理人、事務、講師など
            // Laravel自動管理
            $table->timestamps(); // created_at / updated_at
            $table->softDeletes(); // deleted_at

            // 追加のユーザー情報
            $table->string('created_user_name', 50)->nullable()->comment('作成者名');
            $table->string('updated_user_name', 50)->nullable()->comment('更新者名');
            $table->string('deleted_user_name', 50)->nullable()->comment('削除者名');
        });

        // 初期データ挿入
        DB::table('roles')->insert([
            ['id' => 8, 'role_name' => '管理人',],
            ['id' => 7, 'role_name' => '事務',],
            ['id' => 6, 'role_name' => '講師',],
            ['id' => 5, 'role_name' => 'パート',],
            ['id' => 4, 'role_name' => 'アルバイト',],
            ['id' => 3, 'role_name' => '生徒',],
            ['id' => 2, 'role_name' => 'GUEST',],
            ['id' => 1, 'role_name' => 'ログイン不可',],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
