<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('organizers')->insert([
            [
                'id'   => 1,
                'name' => 'ポリテクセンター',
            ],
            [
                'id'   => 2,
                'name' => 'テクノスクール',
            ],
            [
                'id'   => 3,
                'name' => 'クリップ',
            ],
            [
                'id'   => 4,
                'name' => 'その他',
            ],
        ]);
    }
}
