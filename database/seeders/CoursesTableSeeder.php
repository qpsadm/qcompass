<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CoursesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('courses')->insert([
            [
                'course_code' => 'C01',
                'course_type_ID' => 1,
                'Level_id' => 1,
                'course_name' => 'Laravel入門',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_code' => 'C02',
                'course_type_ID' => 2,
                'Level_id' => 1,
                'course_name' => 'PHP基礎',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_code' => 'C03',
                'course_type_ID' => 3,
                'Level_id' => 1,
                'course_name' => 'Webプログラマー',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_code' => 'C02',
                'course_type_ID' => 2,
                'Level_id' => 1,
                'course_name' => 'OA基礎',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'course_code' => 'C04',
                'course_type_ID' => 4,
                'Level_id' => 1,
                'course_name' => 'Webデザイン',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            [
                'course_code' => 'C101',
                'course_type_ID' => 101,
                'Level_id' => 1,
                'course_name' => 'システム管理者',
                'status' => 'published',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
