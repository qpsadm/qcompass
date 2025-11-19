<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ThemesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('themes')->insert([
            ['id' => 1, 'code' => 'thm_01', 'name' => 'デフォルト', 'is_show' => true],
            ['id' => 2, 'code' => 'thm_02', 'name' => 'ダーク',     'is_show' => true],
            ['id' => 3, 'code' => 'thm_03', 'name' => 'ライト',     'is_show' => true],
            ['id' => 4, 'code' => 'thm_04', 'name' => '赤系',       'is_show' => true],
            ['id' => 5, 'code' => 'thm_05', 'name' => '青系',       'is_show' => true],
            ['id' => 6, 'code' => 'thm_06', 'name' => '緑系',       'is_show' => true],
        ]);
    }
}
