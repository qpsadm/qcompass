<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // SQLite の場合は外部キー制約を一時的に OFF
        DB::statement('PRAGMA foreign_keys = OFF;');

        // 既存データをクリア
        DB::table('roles')->truncate();

        // 初期データ挿入
        DB::table('roles')->insert([
            ['id' => 1, 'role_name' => 'ログイン不可',],
            ['id' => 2, 'role_name' => 'GUEST',],
            ['id' => 3, 'role_name' => '生徒',],
            ['id' => 4, 'role_name' => 'アルバイト',],
            ['id' => 5, 'role_name' => 'パート',],
            ['id' => 6, 'role_name' => '講師',],
            ['id' => 7, 'role_name' => '事務',],
            ['id' => 8, 'role_name' => '管理人',],
        ]);


        // SQLite の外部キー制約を再有効化
        DB::statement('PRAGMA foreign_keys = ON;');
    }
}
