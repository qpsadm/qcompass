<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('course_types')->insert([
            ['id' => 1,  'organizer_id' => 1, 'name' => 'p_基礎',                 'is_show' => true],
            ['id' => 2,  'organizer_id' => 1, 'name' => 'p_営業販売事務分野',     'is_show' => true],
            ['id' => 3,  'organizer_id' => 1, 'name' => 'p_デジタル系（IT）',     'is_show' => true],
            ['id' => 4,  'organizer_id' => 1, 'name' => 'p_デジタル系（WEBデザイン）', 'is_show' => true],
            ['id' => 5,  'organizer_id' => 1, 'name' => 'p_介護分野',             'is_show' => true],
            ['id' => 6,  'organizer_id' => 1, 'name' => 'p_その他',               'is_show' => true],

            ['id' => 7,  'organizer_id' => 2, 'name' => 't_情報系',               'is_show' => true],
            ['id' => 8,  'organizer_id' => 2, 'name' => 't_事務系',               'is_show' => true],
            ['id' => 9,  'organizer_id' => 2, 'name' => 't_デジタル系',           'is_show' => true],
            ['id' => 10, 'organizer_id' => 2, 'name' => 't_建設系',               'is_show' => true],
            ['id' => 11, 'organizer_id' => 2, 'name' => 't_サービス系',           'is_show' => true],
            ['id' => 12, 'organizer_id' => 2, 'name' => 't_介護系',               'is_show' => true],

            ['id' => 13, 'organizer_id' => 3, 'name' => 'q_ゲームクリエイター',   'is_show' => true],
            ['id' => 14, 'organizer_id' => 3, 'name' => 'q_ロボカップ',           'is_show' => true],
            ['id' => 15, 'organizer_id' => 3, 'name' => 'q_UNITY',                'is_show' => true],
            ['id' => 16, 'organizer_id' => 3, 'name' => 'q_WEBデザイン',          'is_show' => true],
            ['id' => 17, 'organizer_id' => 3, 'name' => 'q_プログラミング',       'is_show' => true],
            ['id' => 18, 'organizer_id' => 3, 'name' => 'q_資格取得',             'is_show' => true],
            ['id' => 19, 'organizer_id' => 3, 'name' => 'q_セミナー',             'is_show' => true],
        ]);
    }
}
