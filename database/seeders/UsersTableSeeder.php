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
            [ //生徒さん
                'code' => 'student01',
                'name' => 'テスト学生',
                'email' => 'student@example.com',
                'password' => Hash::make('password'),
                'courses_id' => 2, // PHP基礎
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [ //事務局さん
                'code' => 'officer01',
                'name' => 'テスト事務局',
                'email' => 'officer@example.com',
                'password' => Hash::make('Password'),
                'courses_id' => 3, //
                'role_id' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [ //管理者さん
                'code' => 'admin01',
                'name' => 'テスト管理者',
                'email' => 'admin01@example.com',
                'password' => Hash::make('Administer'),
                'courses_id' => 101, // 管理者
                'role_id' => 101,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [ //非常勤さん
                'code' => 'parttime01',
                'name' => 'テスト非常勤',
                'email' => 'parttime@part-example.com',
                'password' => Hash::make('PassWord'),
                'courses_id' => 4, // PHP基礎
                'role_id' => 4,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'yaruoyaruo01',
                'name' => 'テストやる夫',
                'email' => 'boom.yaruo@example.com',
                'password' => Hash::make('PassWord'),
                'courses_id' => 2, // PHP基礎
                'role_id' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'code' => 'yiankutku01',
                'name' => 'テスト クック先生',
                'email' => 'kutku.sensei@example.com',
                'password' => Hash::make('password'),
                'courses_id' => 1, // PHP基礎
                'role_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
