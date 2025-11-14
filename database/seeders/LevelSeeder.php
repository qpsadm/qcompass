<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('levels')->insert([
            [
                'code' => 'BASIC',
                'name' => '基礎',
            ],
            [
                'code' => 'ADV',
                'name' => '実践（応用）',
            ],
        ]);
    }
}