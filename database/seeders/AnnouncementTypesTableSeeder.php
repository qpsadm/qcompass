<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementTypesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('announcement_types')->insert([
            ['type_name' => 'お知らせ', 'is_show' => true],
            ['type_name' => '生徒募集', 'is_show' => true],
            ['type_name' => '企業説明会', 'is_show' => true],
            ['type_name' => 'イベント', 'is_show' => true],
            ['type_name' => 'セミナー', 'is_show' => true],
            ['type_name' => 'その他', 'is_show' => true],
        ]);
    }
}
