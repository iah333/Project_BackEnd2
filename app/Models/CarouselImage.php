<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselImage extends Model
{
    protected $table = 'carousel_images';

    protected $fillable = ['danh_muc_id', 'image_path'];

    public function danhMuc()
    {
        return $this->belongsTo(DanhMucSanPham::class, 'danh_muc_id', 'id');
    }
}

