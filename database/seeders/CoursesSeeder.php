<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesSeeder extends Seeder
{
    public function run(): void
    {
        // 外部キー制約を一時的に OFF
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        // 既存データをクリア
        DB::table('courses')->truncate();

        DB::table('courses')->insert([
            [
                'course_code' => 'tws10',
                'course_name' => 'WEBシステム開発実践科1第10期',
                'course_type_id' => 7, // course_types テーブルの存在を確認
                'level_id' => 2,       // levels テーブルの存在を確認
                'organizer_id' => 2,   // organizers テーブルの存在を確認
                'venue' => '株式会社QLIPインターナショナル QLIPプログラミングスクール徳島本校',
                'application_date' => '2025/02/21',
                'certification_date' => '2025/03/10',
                'certification_number' => 'CERT-001',
                'start_date' => '2025/05/22',
                'end_date' => '2050/12/31',
                'total_hours' => 653,
                'periods' => 6,
                'start_time' => '09:40:00',
                'finish_time' => '16:20:00',
                'start_viewing' => '2025-10-30',
                'finish_viewing' => '2025-12-19',
                'description' => '本講座は、HTML5、CSS3、JavaScript等を用いたWebページのデザイン技術から始め、PHPプログラミングやLaravelを用いたWebアプリ作成技術まで、実践的なWEBシステム開発の技術を習得することを目的としています。',
                'mail_address' => 'teachers@qlipinternational.co.jp',
                'cc_address' => '',
                'status' => '2',
                'plan_path' => 'plans/C001.pdf',
                'flier_path' => 'fliers/C001.pdf',
                'capacity' => 20,
                'entering' => 13,
                'completed' => 8,
                'is_show' => true,
                'created_at' => now(),
                'created_user_name' => 'システム管理者',
                'updated_at' => now(),
                'updated_user_name' => 'システム管理者',
            ],

            // 他の講座も同様に追加
        ]);

        // 外部キー制約を再有効化
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
