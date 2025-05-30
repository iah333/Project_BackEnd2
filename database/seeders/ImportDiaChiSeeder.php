<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ThanhPho;
use App\Models\QuanHuyen;
use App\Models\PhuongXa;

class ImportDiaChiSeeder extends Seeder
{
    public function run(): void
    {
        $file = fopen(storage_path('app/diachi.csv'), 'r');
        $header = fgetcsv($file); // Bỏ qua dòng tiêu đề

        $thanhPhoMap = [];
        $quanHuyenMap = [];

        while (($row = fgetcsv($file)) !== false) {
            [$thanh_pho_id, $ten_thanh_pho, $quan_huyen_id, $ten_quan_huyen, $phuong_xa_id, $ten_phuong_xa] = $row;

            // Thêm Thành Phố nếu chưa tồn tại
            if (!isset($thanhPhoMap[$thanh_pho_id])) {
                ThanhPho::updateOrCreate(
                    ['id' => $thanh_pho_id],
                    ['ten_thanh_pho' => $ten_thanh_pho]
                );
                $thanhPhoMap[$thanh_pho_id] = true;
            }

            // Thêm Quận/Huyện nếu chưa tồn tại
            if (!isset($quanHuyenMap[$quan_huyen_id])) {
                QuanHuyen::updateOrCreate(
                    ['id' => $quan_huyen_id],
                    ['thanh_pho_id' => $thanh_pho_id, 'ten_quan_huyen' => $ten_quan_huyen]
                );
                $quanHuyenMap[$quan_huyen_id] = true;
            }

            // Thêm Phường/Xã
            PhuongXa::updateOrCreate(
                ['id' => $phuong_xa_id],
                ['quan_huyen_id' => $quan_huyen_id, 'ten_phuong_xa' => $ten_phuong_xa]
            );
        }

        fclose($file);
    }
}