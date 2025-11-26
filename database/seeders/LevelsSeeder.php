<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelsSeeder extends Seeder
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
        DB::table('levels')->truncate();

        $levels = [
            [
                'id' => 1,
                'code' => 'lvl_1',
                'name' => '基礎',
                'is_show' => true,
                'created_user_name' => 'システム管理者',
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 2,
                'code' => 'lvl_2',
                'name' => '実践',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 3,
                'code' => 'lvl_3',
                'name' => 'ＩＴセミナー',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],
        ];

        DB::table('levels')->insert($levels);

        // 外部キー制約を再有効化
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
