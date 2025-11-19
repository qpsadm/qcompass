<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelsTableSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            ['id' => 1, 'code' => 'lvl_1', 'name' => '基礎', 'is_show' => true],
            ['id' => 2, 'code' => 'lvl_2', 'name' => '実践', 'is_show' => true],
            ['id' => 3, 'code' => 'lvl_3', 'name' => 'ＩＴセミナー', 'is_show' => true],
        ];

        DB::table('levels')->insert($levels);
    }
}
