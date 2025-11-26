<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // 外部キー制約を一時的に OFF
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // 既存データを削除
        DB::table('users')->truncate();

        DB::table('users')->insert([
            [
                'code' => 'webadmin',
                'name' => 'システム管理者',
                'furigana' => 'システムカンリシャ',
                'roman_name' => 'Qlip Admin',
                'password' => bcrypt('Qlip123!'),
                'role_id' => 8,          // 管理者
                'division_id' => 1,      // 所属部署ID
                'remember_token' => Str::random(10),
                'email' => 'webmaster@gmail.com',
                'email_verified_at' => now(),
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'code' => 'qlip-teacher',
                'name' => 'QLIP講師',
                'furigana' => 'クリップ コウシ',
                'roman_name' => 'Qlip Teacher',
                'password' => bcrypt('Qlip123!'),
                'role_id' => 6,          // 講師
                'division_id' => 2,      // 所属部署ID
                'remember_token' => Str::random(10),
                'email' => 'teacher@gmail.com',
                'email_verified_at' => now(),
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'code' => 'qlip-officer',
                'name' => 'QLIP事務員',
                'furigana' => 'クリップ ジムイン',
                'roman_name' => 'Qlip officer',
                'password' => bcrypt('Qlip123!'),
                'role_id' => 7,          // 事務員
                'division_id' => 3,      // 所属部署ID
                'remember_token' => Str::random(10),
                'email' => 'officer@gmail.com',
                'email_verified_at' => now(),
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],


            [
                'code' => 'qlip-part',
                'name' => '外部講師',
                'furigana' => 'ガイブコウシ',
                'roman_name' => 'Adjunct Teacher',
                'password' => bcrypt('Qlip123!'),
                'role_id' => 5,          // 外部講師
                'division_id' => 2,      // 所属部署ID
                'remember_token' => Str::random(10),
                'email' => 'adjunct@gmail.com',
                'email_verified_at' => now(),
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            [
                'code' => 'tws10-01',
                'name' => '山田　太郎',
                'furigana' => 'ヤマダ　タロウ',
                'roman_name' => 'yamada taro',
                'password' => bcrypt('Qlip123!'),
                'role_id' => 3,          // 生徒
                'division_id' => 5,      // ハロワーク徳島
                'remember_token' => Str::random(10),
                'email' => 'taro@gmail.com',
                'email_verified_at' => now(),
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
