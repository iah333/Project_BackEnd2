<?php

namespace App\Http\Controllers;

use App\Models\DanhMucSanPham;
use Illuminate\Http\Request;

class DanhMucSanPhamController extends Controller
{
    public function index()
    {
        $danhMucs = DanhMucSanPham::all();
        return view('admin.danh-muc.index', compact('danhMucs'));
    }

    public function create()
    {
        return view('admin.danh-muc.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255',
        ]);

        DanhMucSanPham::create([
            'ten_danh_muc' => $request->ten_danh_muc,
        ]);

        return redirect()->route('danhMuc.index')->with('success', 'Danh mục đã được tạo!');
    }

    public function edit($ma_danh_muc)
    {
        $danhMuc = DanhMucSanPham::findOrFail($ma_danh_muc);
        return view('admin.danh-muc.edit', compact('danhMuc'));
    }

    public function update(Request $request, $ma_danh_muc)
    {
        $request->validate([
            'ten_danh_muc' => 'required|string|max:255',
        ]);

        $danhMuc = DanhMucSanPham::findOrFail($ma_danh_muc);
        $danhMuc->update([
            'ten_danh_muc' => $request->ten_danh_muc,
        ]);

        return redirect()->route('danhMuc.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    public function destroy($ma_danh_muc)
    {
        $danhMuc = DanhMucSanPham::findOrFail($ma_danh_muc);
        $danhMuc->delete();

        return redirect()->route('danhMuc.index')->with('success', 'Danh mục đã được xóa!');
    }
    public function showBySlug($slug)
    {
        $danhMuc = DanhMucSanPham::where('ten_danh_muc', $slug)->with('sanPhams')->firstOrFail();
        $danhMucs = DanhMucSanPham::all();
        return view('admin.danh-muc.show', compact('danhMuc', 'danhMucs'));
    }
}
