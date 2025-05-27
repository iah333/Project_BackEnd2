<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SanPham;

class SanPhamSeeder extends Seeder
{
    public function run()
    {
        $file = fopen(base_path('database/data/sanpham.csv'), 'r');
        $header = fgetcsv($file); // Đọc dòng tiêu đề

        while (($row = fgetcsv($file)) !== false) {
            SanPham::create([
                'danhmuc_id' => $row[0],
                'ten_san_pham' => $row[1],
                'gia' => $row[2],
                'so_luong_ton' => $row[3],
                'anh' => $row[4],
            ]);
        }

        fclose($file);
    }
}