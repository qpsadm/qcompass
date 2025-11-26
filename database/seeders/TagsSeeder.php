<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
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
        DB::table('tags')->truncate();

        DB::table('tags')->insert([
            [
                'id' => 1,
                'code' => 'tag_01',
                'name' => 'ハードウェア',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 2,
                'code' => 'tag_02',
                'name' => 'ソフトウェア',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 3,
                'code' => 'tag_03',
                'name' => 'ネットワーク・通信',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 4,
                'code' => 'tag_04',
                'name' => 'データ・情報処理',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 5,
                'code' => 'tag_05',
                'name' => 'プログラミング',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 6,
                'code' => 'tag_06',
                'name' => 'WEB制作',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 7,
                'code' => 'tag_07',
                'name' => 'WEBデザイン',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 8,
                'code' => 'tag_08',
                'name' => 'セキュリティ',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 9,
                'code' => 'tag_09',
                'name' => '資格',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 10,
                'code' => 'tag_10',
                'name' => '就職支援',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 11,
                'code' => 'tag_11',
                'name' => '訓練校について',
                'is_show' => true,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者'
            ],

            [
                'id' => 12,
                'code' => 'tag_12',
                'name' => 'その他',
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
