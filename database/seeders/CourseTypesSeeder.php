<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseTypesSeeder extends Seeder
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
        DB::table('course_types')->truncate();

        DB::table('course_types')->insert([
            [
                'id' => 1,
                'organizer_id' => 1,
                'name' => 'p_基礎',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 2,
                'organizer_id' => 1,
                'name' => 'p_営業販売事務分野',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 3,
                'organizer_id' => 1,
                'name' => 'p_デジタル系（IT）',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 4,
                'organizer_id' => 1,
                'name' => 'p_デジタル系（WEBデザイン）',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 5,
                'organizer_id' => 1,
                'name' => 'p_介護分野',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 6,
                'organizer_id' => 1,
                'name' => 'p_その他',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],


            [
                'id' => 7,
                'organizer_id' => 2,
                'name' => 't_情報系',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 8,
                'organizer_id' => 2,
                'name' => 't_事務系',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 9,
                'organizer_id' => 2,
                'name' => 't_デジタル系',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 10,
                'organizer_id' => 2,
                'name' => 't_建設系',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 11,
                'organizer_id' => 2,
                'name' => 't_サービス系',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 12,
                'organizer_id' => 2,
                'name' => 't_介護系',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],


            [
                'id' => 13,
                'organizer_id' => 3,
                'name' => 'q_ゲームクリエイター',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 14,
                'organizer_id' => 3,
                'name' => 'q_ロボカップ',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 15,
                'organizer_id' => 3,
                'name' => 'q_UNITY',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 16,
                'organizer_id' => 3,
                'name' => 'q_WEBデザイン',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 17,
                'organizer_id' => 3,
                'name' => 'q_プログラミング',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 18,
                'organizer_id' => 3,
                'name' => 'q_資格取得',
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'id' => 19,
                'organizer_id' => 3,
                'name' => 'q_セミナー',
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
