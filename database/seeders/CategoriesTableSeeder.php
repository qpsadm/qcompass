<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        $categories = [
            [
                'code' => 'C01',
                'name' => '基礎',
                'parent_id' => null,
                'top_id' => null,
                'level' => 1,
                'child_count' => 2,
                'is_show' => true,
                'theme_color' => 'blue',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'C02',
                'name' => '応用',
                'parent_id' => null,
                'top_id' => null,
                'level' => 1,
                'child_count' => 0,
                'is_show' => true,
                'theme_color' => 'blue',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'C01-01',
                'name' => '基礎A',
                'parent_id' => 1,
                'top_id' => 1,
                'level' => 2,
                'child_count' => 0,
                'is_show' => true,
                'theme_color' => 'blue',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'C01-02',
                'name' => '基礎B',
                'parent_id' => 1,
                'top_id' => 1,
                'level' => 2,
                'child_count' => 0,
                'is_show' => true,
                'theme_color' => 'blue',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}