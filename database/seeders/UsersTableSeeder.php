<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'code' => 'teacher01',
                'name' => 'テスト教師',
                'email' => 'teacher@example.com',
                'password' => Hash::make('password'),
                'courses_id' => 1, // Laravel入門
                'role_id' => 1,    // 管理者とか
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'student01',
                'name' => 'テスト学生',
                'email' => 'student@example.com',
                'password' => Hash::make('password'),
                'courses_id' => 2, // PHP基礎
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
