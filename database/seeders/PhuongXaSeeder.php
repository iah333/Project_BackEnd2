<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PhuongXa; 


class PhuongXaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PhuongXa::create(['quan_huyen_id' => 1, 'ten_phuong_xa' => 'Phường Trúc Bạch']);
        PhuongXa::create(['quan_huyen_id' => 1, 'ten_phuong_xa' => 'Phường Nguyễn Trung Trực']);
        PhuongXa::create(['quan_huyen_id' => 2, 'ten_phuong_xa' => 'Phường Hàng Trống']);
        PhuongXa::create(['quan_huyen_id' => 3, 'ten_phuong_xa' => 'Phường Bến Nghé']);
        PhuongXa::create(['quan_huyen_id' => 4, 'ten_phuong_xa' => 'Phường 3']);
    }
}
