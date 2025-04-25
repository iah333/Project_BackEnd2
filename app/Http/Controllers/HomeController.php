<?php

namespace App\Http\Controllers;

use App\Models\DanhMucSanPham;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        $danhMucs = DanhMucSanPham::all();
        $danhMucSanPham = DanhMucSanPham::with('sanPhams')->get();
        return view('welcome', compact('danhMucs','danhMucSanPham'));
    }
}
