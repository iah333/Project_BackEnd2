<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ThanhPho;

class ThanhPhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ThanhPho::create(['ten_thanh_pho' => 'Hà Nội']);
        ThanhPho::create(['ten_thanh_pho' => 'TP. Hồ Chí Minh']);
        ThanhPho::create(['ten_thanh_pho' => 'Đà Nẵng']);
        ThanhPho::create(['ten_thanh_pho' => 'Hải Phòng']);
        ThanhPho::create(['ten_thanh_pho' => 'Cần Thơ']);
        ThanhPho::create(['ten_thanh_pho' => 'Huế']);
        ThanhPho::create(['ten_thanh_pho' => 'Nha Trang']);
    }
}