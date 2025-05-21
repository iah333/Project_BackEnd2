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
        QuanHuyen::create(['thanh_pho_id' => 1, 'ten_quan_huyen' => 'Ba Đình']);
        QuanHuyen::create(['thanh_pho_id' => 1, 'ten_quan_huyen' => 'Hoàn Kiếm']);
        QuanHuyen::create(['thanh_pho_id' => 2, 'ten_quan_huyen' => 'Quận 1']);
        QuanHuyen::create(['thanh_pho_id' => 2, 'ten_quan_huyen' => 'Quận 3']);
    }
}
