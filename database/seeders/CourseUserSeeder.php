<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CourseUserSeeder extends Seeder
{
    public function run(): void
    {
        // まずユーザーとコースが存在していることを前提とします
        // ユーザーIDとコースIDを指定して中間テーブルに挿入
        DB::table('course_users')->insert([
            [
                'user_id' => 1,
                'course_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'course_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 101,
                'course_id' => 101,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
