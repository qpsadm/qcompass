<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseUserSeeder extends Seeder
{
    public function run()
    {
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
    }
}
