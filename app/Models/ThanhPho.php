<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThanhPho extends Model
{
    protected $table = 'thanh_pho';
    protected $fillable = ['ten_thanh_pho'];

    public function quanHuyens()
    {
        return $this->hasMany(QuanHuyen::class, 'thanh_pho_id');
    }
}