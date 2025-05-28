<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhMucSanPham extends Model
{
    protected $table = 'danhmuc';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['ten_danh_muc'];

    // Mối quan hệ: Một danh mục có nhiều sản phẩm
    public function sanPhams()
    {
        return $this->hasMany(SanPham::class, 'danhmuc_id', 'id');
    }
}