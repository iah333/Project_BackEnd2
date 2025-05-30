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
        // Ba Đình, Hà Nội (quan_huyen_id: 1)
        PhuongXa::create(['quan_huyen_id' => 1, 'ten_phuong_xa' => 'Phường Trúc Bạch']);
        PhuongXa::create(['quan_huyen_id' => 1, 'ten_phuong_xa' => 'Phường Nguyễn Trung Trực']);
        PhuongXa::create(['quan_huyen_id' => 1, 'ten_phuong_xa' => 'Phường Quán Thánh']);
        
        // Hoàn Kiếm, Hà Nội (quan_huyen_id: 2)
        PhuongXa::create(['quan_huyen_id' => 2, 'ten_phuong_xa' => 'Phường Hàng Trống']);
        PhuongXa::create(['quan_huyen_id' => 2, 'ten_phuong_xa' => 'Phường Hàng Bông']);
        
        // Cầu Giấy, Hà Nội (quan_huyen_id: 3)
        PhuongXa::create(['quan_huyen_id' => 3, 'ten_phuong_xa' => 'Phường Dịch Vọng']);
        PhuongXa::create(['quan_huyen_id' => 3, 'ten_phuong_xa' => 'Phường Quan Hoa']);
        
        // Đống Đa, Hà Nội (quan_huyen_id: 4)
        PhuongXa::create(['quan_huyen_id' => 4, 'ten_phuong_xa' => 'Phường Ô Chợ Dừa']);
        PhuongXa::create(['quan_huyen_id' => 4, 'ten_phuong_xa' => 'Phường Láng Thượng']);
        
        // Quận 1, TP. Hồ Chí Minh (quan_huyen_id: 5)
        PhuongXa::create(['quan_huyen_id' => 5, 'ten_phuong_xa' => 'Phường Bến Nghé']);
        PhuongXa::create(['quan_huyen_id' => 5, 'ten_phuong_xa' => 'Phường Nguyễn Thái Bình']);
        
        // Quận 3, TP. Hồ Chí Minh (quan_huyen_id: 6)
        PhuongXa::create(['quan_huyen_id' => 6, 'ten_phuong_xa' => 'Phường 3']);
        PhuongXa::create(['quan_huyen_id' => 6, 'ten_phuong_xa' => 'Phường Võ Thị Sáu']);
        
        // Quận 7, TP. Hồ Chí Minh (quan_huyen_id: 7)
        PhuongXa::create(['quan_huyen_id' => 7, 'ten_phuong_xa' => 'Phường Tân Phú']);
        PhuongXa::create(['quan_huyen_id' => 7, 'ten_phuong_xa' => 'Phường Tân Thuận Đông']);
        
        // Bình Thạnh, TP. Hồ Chí Minh (quan_huyen_id: 8)
        PhuongXa::create(['quan_huyen_id' => 8, 'ten_phuong_xa' => 'Phường 13']);
        PhuongXa::create(['quan_huyen_id' => 8, 'ten_phuong_xa' => 'Phường 15']);
        
        // Hải Châu, Đà Nẵng (quan_huyen_id: 9)
        PhuongXa::create(['quan_huyen_id' => 9, 'ten_phuong_xa' => 'Phường Thạch Thang']);
        PhuongXa::create(['quan_huyen_id' => 9, 'ten_phuong_xa' => 'Phường Hải Châu I']);
        
        // Thanh Khê, Đà Nẵng (quan_huyen_id: 10)
        PhuongXa::create(['quan_huyen_id' => 10, 'ten_phuong_xa' => 'Phường Thanh Khê Đông']);
        PhuongXa::create(['quan_huyen_id' => 10, 'ten_phuong_xa' => 'Phường Xuân Hà']);
        
        // Hồng Bàng, Hải Phòng (quan_huyen_id: 11)
        PhuongXa::create(['quan_huyen_id' => 11, 'ten_phuong_xa' => 'Phường Quán Toan']);
        PhuongXa::create(['quan_huyen_id' => 11, 'ten_phuong_xa' => 'Phường Hùng Vương']);
        
        // Ngô Quyền, Hải Phòng (quan_huyen_id: 12)
        PhuongXa::create(['quan_huyen_id' => 12, 'ten_phuong_xa' => 'Phường Máy Tơ']);
        PhuongXa::create(['quan_huyen_id' => 12, 'ten_phuong_xa' => 'Phường Lạch Tray']);
        
        // Ninh Kiều, Cần Thơ (quan_huyen_id: 13)
        PhuongXa::create(['quan_huyen_id' => 13, 'ten_phuong_xa' => 'Phường Cái Khế']);
        PhuongXa::create(['quan_huyen_id' => 13, 'ten_phuong_xa' => 'Phường An Hòa']);
        
        // Cái Răng, Cần Thơ (quan_huyen_id: 14)
        PhuongXa::create(['quan_huyen_id' => 14, 'ten_phuong_xa' => 'Phường Lê Bình']);
        PhuongXa::create(['quan_huyen_id' => 14, 'ten_phuong_xa' => 'Phường Hưng Phú']);
        
        // Phú Nhuận, Huế (quan_huyen_id: 15)
        PhuongXa::create(['quan_huyen_id' => 15, 'ten_phuong_xa' => 'Phường Phú Hội']);
        PhuongXa::create(['quan_huyen_id' => 15, 'ten_phuong_xa' => 'Phường Phú Cát']);
        
        // Hương Thủy, Huế (quan_huyen_id: 16)
        PhuongXa::create(['quan_huyen_id' => 16, 'ten_phuong_xa' => 'Phường Thủy Xuân']);
        PhuongXa::create(['quan_huyen_id' => 16, 'ten_phuong_xa' => 'Phường Thủy Biều']);
        
        // Vĩnh Thọ, Nha Trang (quan_huyen_id: 17)
        PhuongXa::create(['quan_huyen_id' => 17, 'ten_phuong_xa' => 'Phường Vĩnh Thọ']);
        PhuongXa::create(['quan_huyen_id' => 17, 'ten_phuong_xa' => 'Phường Ngọc Hiệp']);
        
        // Vĩnh Nguyên, Nha Trang (quan_huyen_id: 18)
        PhuongXa::create(['quan_huyen_id' => 18, 'ten_phuong_xa' => 'Phường Vĩnh Nguyên']);
        PhuongXa::create(['quan_huyen_id' => 18, 'ten_phuong_xa' => 'Phường Vĩnh Phước']);
    }
}