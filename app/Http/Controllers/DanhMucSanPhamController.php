<?php

namespace App\Http\Controllers;

use App\Http\Requests\DanhMucSanPhamRequest;
use App\Models\DanhMucSanPham;

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

    public function store(DanhMucSanPhamRequest $request)
    {
        DanhMucSanPham::create([
            'ten_danh_muc' => $request->ten_danh_muc,
        ]);

        return redirect()->route('danhMuc.index')->with('success', 'Danh mục đã được tạo!');
    }

    public function edit($id)
    {
        $danhMuc = DanhMucSanPham::findOrFail($id);
        return view('admin.danh-muc.edit', compact('danhMuc'));
    }

    public function update(DanhMucSanPhamRequest $request, $id)
    {
        $danhMuc = DanhMucSanPham::findOrFail($id);
        $danhMuc->update([
            'ten_danh_muc' => $request->ten_danh_muc,
        ]);

        return redirect()->route('danhMuc.index')->with('success', 'Danh mục đã được cập nhật!');
    }

    public function destroy($id)
    {
        $danhMuc = DanhMucSanPham::findOrFail($id);
        $danhMuc->delete();

        return redirect()->route('danhMuc.index')->with('success', 'Danh mục đã được xóa!');
    }

    public function showBySlug($slug)
    {
        $danhMuc = DanhMucSanPham::where('ten_danh_muc', $slug)->with('sanPhams')->firstOrFail();
        $danhMucs = DanhMucSanPham::all();
        return view('admin.danh-muc.show', compact('danhMuc', 'danhMucs'));
    }
    public function show($id)
    {
        $danhMuc = DanhMucSanPham::with('carouselImages')->findOrFail($id);

        return view('admin.danhmuc.show', compact('danhMuc'));
    }
}