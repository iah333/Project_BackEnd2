<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarouselImagesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('carousel_images')->insert([
            [
                'danh_muc_id' => 1,
                'image_path' => 'banner_iphone15.png', // lưu trong public/img/
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'danh_muc_id' => 1,
                'image_path' => 'banner_iPhone16pro_max.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'danh_muc_id' => 1,
                'image_path' => 'banner_iP16sr_PC.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'danh_muc_id' => 2,
                'image_path' => 'banner_ipad1.png', // lưu trong public/img/
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'danh_muc_id' => 2,
                'image_path' => 'banner_ipad2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'danh_muc_id' => 2,
                'image_path' => 'banner_ipad3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'danh_muc_id' => 3,
                'image_path' => 'banner_mc1.png', // lưu trong public/img/
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'danh_muc_id' => 3,
                'image_path' => 'banner_mc2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'danh_muc_id' => 3,
                'image_path' => 'banner_mc3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'danh_muc_id' => 4,
                'image_path' => 'banner Wsr_1.png', // lưu trong public/img/
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'danh_muc_id' => 4,
                'image_path' => 'banner Wsr_2.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'danh_muc_id' => 4,
                'image_path' => 'banner Wsr_3.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}

