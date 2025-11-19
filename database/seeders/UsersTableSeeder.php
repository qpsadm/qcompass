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
                'code' => 'U001',
                'name' => '山田 太郎',
                'furigana' => 'ヤマダ タロウ',
                'roman_name' => 'Yamada Taro',
                'password' => bcrypt('password123'),
                'role_id' => 8,          // 管理者
                'division_id' => 1,      // 所属部署ID
                'courses_id' => 1,       // 存在する course の ID
                'remember_token' => Str::random(10),
                'email' => 'taro@example.com',
                'email_verified_at' => now(),
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'system',
                'updated_at' => now(),
                'updated_user_name' => 'system',
            ],
        ]);
    }
}
