<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CourseUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('course_users')->insert([
            [
                'user_id' => 1,
                'course_id' => 1,
                'created_user_name' => 'admin',
                'updated_user_name' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
