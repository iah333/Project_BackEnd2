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
            ['id'=> 1,'ten_danh_muc' => 'iPhone'],
            ['id'=> 2,'ten_danh_muc' => 'iPad'],
            ['id'=> 3,'ten_danh_muc' => 'Mac'],
            ['id'=> 4,'ten_danh_muc' => 'Watch'],
        ];

        foreach ($danhMucs as $danhMuc) {
            DanhMucSanPham::create($danhMuc);
        }
    }
}