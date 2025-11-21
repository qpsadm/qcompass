<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Division;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'code' => 'HW01',
                'name' => 'ハローワーク徳島',
                'tel' => '088-622-6374',
                'post_code' => '7700823',
                'address' => '徳島県徳島市出来島本町1丁目5番地',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'HW02',
                'name' => 'ハローワーク小松島',
                'tel' => '0885-32-3314',
                'post_code' => '7730001',
                'address' => '徳島県小松島市小松島町外開1-11',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'HW03',
                'name' => 'ハローワーク三好',
                'tel' => '0883-72-1221',
                'post_code' => '7780002',
                'address' => '徳島県三好市池田町マチ2429-10',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'HW04',
                'name' => 'ハローワーク美馬',
                'tel' => '0883-52-8609',
                'post_code' => '7793602',
                'address' => '徳島県美馬市脇町大字猪尻字東分5番地',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'HW05',
                'name' => 'ハローワーク阿南',
                'tel' => '0884-22-2016',
                'post_code' => '7740030',
                'address' => '徳島県阿南市領家町本荘ヶ内120-6',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'HW06',
                'name' => 'ハローワーク吉野川',
                'tel' => '0883-24-2166',
                'post_code' => '7760010',
                'address' => '徳島県吉野川市鴨島町鴨島388-27',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'HW07',
                'name' => 'ハローワーク鳴門',
                'tel' => '088-685-2270',
                'post_code' => '7720003',
                'address' => '徳島県鳴門市撫養町南浜字権現12',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'HW08',
                'name' => 'ハローワーク牟岐',
                'tel' => '0884-72-1103',
                'post_code' => '7750006',
                'address' => '徳島県海部郡牟岐町大字中村字本村52-1',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'HW09',
                'name' => 'ハローワーク高松',
                'tel' => '087-806-0047',
                'post_code' => '7618566',
                'address' => '高松市花ノ宮町２－２－３',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'Q01',
                'name' => '総務部',
                'tel' => '088-676-3151',
                'post_code' => '7700832',
                'address' => '徳島県徳島市寺島本町東3丁目 12-8 K1ビル6F',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'Q02',
                'name' => '教育事業部',
                'tel' => '088-676-3151',
                'post_code' => '7700832',
                'address' => '徳島県徳島市寺島本町東3丁目 12-8 K1ビル6F',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
            [
                'code' => 'Q03',
                'name' => '開発部',
                'tel' => '088-676-3151',
                'post_code' => '7700832',
                'address' => '徳島県徳島市寺島本町東3丁目 12-8 K1ビル6F',
                'is_show' => true,
                'memo' => '',
                'created_user_name' => 'system',
            ],
        ];

        foreach ($data as $item) {
            Division::create($item);
        }
    }
}
