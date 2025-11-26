<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseUserSeeder extends Seeder
{
    public function run()
    {
        // SQLite の場合は外部キー制約を一時的に OFF
        DB::statement('PRAGMA foreign_keys = OFF;');

        // 既存データをクリア
        DB::table('course_users')->truncate();

        // 例: ユーザー1と2をコース1に紐づける
        DB::table('course_users')->insert([
            [
                'user_id' => 1,
                'course_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者',
            ],
            [
                'user_id' => 2,
                'course_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_user_name' => 'システム管理者',
            ],
        ]);

        // SQLite の外部キー制約を再有効化
        DB::statement('PRAGMA foreign_keys = ON;');
    }
}
