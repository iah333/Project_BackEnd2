<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'donhang';
    protected $fillable = [
        'user_id',
        'dia_chi_id',
        'ten_nguoi_nhan',
        'so_dien_thoai',
        'ngay_dat',
        'tong_tien',
        'trang_thai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function diaChi()
    {
        return $this->belongsTo(DiaChi::class, 'dia_chi_id');
    }

    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }
}