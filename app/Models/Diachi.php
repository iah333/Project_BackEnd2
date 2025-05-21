<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaChi extends Model
{
    protected $table = 'diachi';

    protected $fillable = ['user_id', 'dia_chi', 'thanh_pho', 'so_dien_thoai'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
