<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
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
                'courses_id' => 1,       // 存在する course の ID
                'remember_token' => Str::random(10),
                'email' => 'webmaster@qlipinternational.co.jp',
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
                'roman_name' => 'Qlip Teacher',
                'password' => bcrypt('Qlip123!'),
                'role_id' => 7,          // 管理者
                'division_id' => 1,      // 所属部署ID
                'courses_id' => 1,       // 存在する course の ID
                'remember_token' => Str::random(10),
                'email' => 'taro@example.com',
                'email_verified_at' => now(),
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => '山田 太郎',
                'updated_at' => now(),
                'updated_user_name' => '山田 太郎',
            ],
        ]);
    }
}
