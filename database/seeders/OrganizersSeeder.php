<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizersSeeder extends Seeder
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
        DB::table('organizers')->truncate();

        DB::table('organizers')->insert([
            [
                'id' => 1,
                'name' => 'ポリテクセンター徳島',
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 2,
                'name' => '徳島県立テクノスクール',
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 3,
                'name' => 'QLIPプログラミングスクール',
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 4,
                'name' => 'その他',
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
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
