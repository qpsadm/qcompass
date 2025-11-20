<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organizers')->insert([
            ['id' => 4, 'name' => 'その他'],
            ['id' => 3, 'name' => 'QLIPプログラミングスクール'],
            ['id' => 2, 'name' => '徳島県立テクノスクール'],
            ['id' => 1, 'name' => 'ポリテクセンター徳島'],
        ]);
    }
}
