<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('courses')->truncate();

        DB::table('courses')->insert([
            [
                'course_code' => 'C001',
                'course_name' => '基礎IT講座',
                'course_type_id' => 1, // course_types テーブルの存在を確認
                'level_id' => 1,       // levels テーブルの存在を確認
                'organizer_id' => 1,   // organizers テーブルの存在を確認
                'venue' => '東京会場',
                'application_date' => '2025-10-20',
                'certification_date' => '2025-11-14',
                'certification_number' => 'CERT-001',
                'start_date' => '2025-10-30',
                'end_date' => '2025-11-29',
                'total_hours' => 40,
                'periods' => 20,
                'start_time' => '09:00:00',
                'finish_time' => '17:00:00',
                'start_viewing' => '2025-10-30',
                'finish_viewing' => '2025-12-19',
                'description' => 'IT基礎の理解を深める講座です。',
                'mail_address' => 'report@example.com',
                'cc_address' => 'cc@example.com',
                'status' => 'open',
                'plan_path' => 'plans/C001.pdf',
                'flier_path' => 'fliers/C001.pdf',
                'capacity' => 30,
                'entering' => 25,
                'completed' => 20,
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'admin',
                'updated_at' => now(),
                'updated_user_name' => 'admin',
            ],

            // 他の講座も同様に追加
        ]);

        DB::statement('PRAGMA foreign_keys = ON;');
    }
}
