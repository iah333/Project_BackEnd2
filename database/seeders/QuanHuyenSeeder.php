<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuanHuyen;

class QuanHuyenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hà Nội (thanh_pho_id: 1)
        QuanHuyen::create(['thanh_pho_id' => 1, 'ten_quan_huyen' => 'Ba Đình']);
        QuanHuyen::create(['thanh_pho_id' => 1, 'ten_quan_huyen' => 'Hoàn Kiếm']);
        QuanHuyen::create(['thanh_pho_id' => 1, 'ten_quan_huyen' => 'Cầu Giấy']);
        QuanHuyen::create(['thanh_pho_id' => 1, 'ten_quan_huyen' => 'Đống Đa']);
        
        // TP. Hồ Chí Minh (thanh_pho_id: 2)
        QuanHuyen::create(['thanh_pho_id' => 2, 'ten_quan_huyen' => 'Quận 1']);
        QuanHuyen::create(['thanh_pho_id' => 2, 'ten_quan_huyen' => 'Quận 3']);
        QuanHuyen::create(['thanh_pho_id' => 2, 'ten_quan_huyen' => 'Quận 7']);
        QuanHuyen::create(['thanh_pho_id' => 2, 'ten_quan_huyen' => 'Bình Thạnh']);
        
        // Đà Nẵng (thanh_pho_id: 3)
        QuanHuyen::create(['thanh_pho_id' => 3, 'ten_quan_huyen' => 'Hải Châu']);
        QuanHuyen::create(['thanh_pho_id' => 3, 'ten_quan_huyen' => 'Thanh Khê']);
        
        // Hải Phòng (thanh_pho_id: 4)
        QuanHuyen::create(['thanh_pho_id' => 4, 'ten_quan_huyen' => 'Hồng Bàng']);
        QuanHuyen::create(['thanh_pho_id' => 4, 'ten_quan_huyen' => 'Ngô Quyền']);
        
        // Cần Thơ (thanh_pho_id: 5)
        QuanHuyen::create(['thanh_pho_id' => 5, 'ten_quan_huyen' => 'Ninh Kiều']);
        QuanHuyen::create(['thanh_pho_id' => 5, 'ten_quan_huyen' => 'Cái Răng']);
        
        // Huế (thanh_pho_id: 6)
        QuanHuyen::create(['thanh_pho_id' => 6, 'ten_quan_huyen' => 'Phú Nhuận']);
        QuanHuyen::create(['thanh_pho_id' => 6, 'ten_quan_huyen' => 'Hương Thủy']);
        
        // Nha Trang (thanh_pho_id: 7)
        QuanHuyen::create(['thanh_pho_id' => 7, 'ten_quan_huyen' => 'Vĩnh Thọ']);
        QuanHuyen::create(['thanh_pho_id' => 7, 'ten_quan_huyen' => 'Vĩnh Nguyên']);
    }
}