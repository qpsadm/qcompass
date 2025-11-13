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
        ]);
    }
}
