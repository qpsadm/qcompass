<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('course_types')->insert([
            [
                'id'   => 1,
                'name' => 'IT情報',
            ],
            [
                'id'   => 2,
                'name' => 'Design',
            ],
            [
                'id'   => 3,
                'name' => '医療',
            ],
            [
                'id'   => 4,
                'name' => '建築',
            ],
        ]);
    }
}
