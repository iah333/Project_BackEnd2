<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DanhMucSanPham;

class DanhMucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $danhMucs = [
            ['ten_danh_muc' => 'iPhone'],
            ['ten_danh_muc' => 'iPad'],
            ['ten_danh_muc' => 'Mac'],
            ['ten_danh_muc' => 'Watch'],
            ['ten_danh_muc' => 'Phụ Kiện'],
            ['ten_danh_muc' => 'Âm Thanh'],
        ];

        foreach ($danhMucs as $danhMuc) {
            DanhMucSanPham::create($danhMuc);
        }
    }
}