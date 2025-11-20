<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementTypeTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('announcement_types')->insert([
            ['id' => 1, 'type_name' => 'お知らせ', 'is_show' => true],
            ['id' => 2, 'type_name' => '生徒募集', 'is_show' => true],
            ['id' => 3, 'type_name' => '企業説明会', 'is_show' => true],
            ['id' => 4, 'type_name' => 'イベント', 'is_show' => true],
            ['id' => 5, 'type_name' => 'セミナー', 'is_show' => true],
            ['id' => 6, 'type_name' => 'その他', 'is_show' => true],
        ]);
    }
}
