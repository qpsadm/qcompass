<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemesSeeder extends Seeder
{
    public function run(): void
    {
        // 外部キー制約を一時的に OFF
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // 既存データをクリア
        DB::table('themes')->truncate();

        DB::table('themes')->insert([
            [
                'id' => 1,
                'code' => 'thm_01',
                'name' => 'デフォルト',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 2,
                'code' => 'thm_02',
                'name' => 'ダーク',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 3,
                'code' => 'thm_03',
                'name' => 'ライト',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 4,
                'code' => 'thm_04',
                'name' => '赤系',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 5,
                'code' => 'thm_05',
                'name' => '青系',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 6,
                'code' => 'thm_06',
                'name' => '緑系',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],
        ]);

        // 外部キー制約を再有効化
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
