<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementTypesSeeder extends Seeder
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
        DB::table('announcement_types')->truncate();

        DB::table('announcement_types')->insert([
            [
                'type_name' => 'お知らせ',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'type_name' => '生徒募集',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'type_name' => '企業説明会',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'type_name' => 'イベント',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'type_name' => 'セミナー',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'type_name' => 'その他',
                'is_show' => true,
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
