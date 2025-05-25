<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    protected $table = 'giohang';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['user_id'];

    public function sanPhams()
    {
        return $this->belongsToMany(SanPham::class, 'giohang_sanpham')
            ->withPivot('so_luong')
            ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
