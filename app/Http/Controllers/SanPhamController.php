<?php

namespace App\Http\Controllers;

use App\Http\Requests\SanPhamRequest;
use App\Models\SanPham;
use App\Models\DanhMucSanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class SanPhamController extends Controller
{
    public function index()
    {
        $sanPhams = SanPham::with('danhMuc')->get();
        return view('admin.san-pham.index', compact('sanPhams'));
    }

    public function search(Request $request)
    {
        try {
            $search = $request->query('search');
            $ma_danh_muc = $request->query('ma_danh_muc');

            $danhMucs = DanhMucSanPham::all();
            $query = SanPham::query();

            if ($search) {
                $query->where('ten_san_pham', 'LIKE', "%{$search}%");
            }

            if ($ma_danh_muc) {
                $query->where('danhmuc_id', $ma_danh_muc);
                session(['current_category' => $ma_danh_muc]);
            } else {
                if ($search) {
                    $firstProduct = $query->first();
                    if ($firstProduct && $firstProduct->danhmuc_id) {
                        $ma_danh_muc = $firstProduct->danhmuc_id;
                        session(['current_category' => $ma_danh_muc]);
                    }
                }
            }

            $sanPhams = $query->with('danhMuc')->paginate(12);
            $tongSoLuong = session('tongSoLuong', 0);

            return view('san-pham.index', compact('sanPhams', 'danhMucs', 'tongSoLuong', 'ma_danh_muc', 'search'))
                ->with('success', session('success'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Không thể tìm kiếm sản phẩm.');
        }
    }

    public function create()
    {
        $danhMucs = DanhMucSanPham::all();
        return view('admin.san-pham.create', compact('danhMucs'));
    }

    public function store(SanPhamRequest $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('anh')) {
                $danhMuc = DanhMucSanPham::findOrFail($request->danhmuc_id);
                $folder = 'img/' . $danhMuc->ten_danh_muc;

                if (!File::exists(public_path($folder))) {
                    File::makeDirectory(public_path($folder), 0755, true);
                }

                $file = $request->file('anh');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($folder), $filename);
                $data['anh'] = $folder . '/' . $filename;
            }

            SanPham::create($data);

            return redirect()->route('sanPham.index')->with('success', 'Sản phẩm đã được tạo!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Không thể thêm sản phẩm: ' . $e->getMessage()]);
        }
    }

    public function show($id)
    {
        \Log::info('SanPhamController@show called', ['user' => Auth::user(), 'id' => $id]);
        $sanPham = SanPham::with('danhMuc')->findOrFail($id);
        $danhMucs = DanhMucSanPham::all();

        if (Auth::check() && Auth::user()->is_admin) {
            return view('admin.san-pham.show', compact('sanPham', 'danhMucs'));
        }

        return view('san-pham.chi-tiet', compact('sanPham', 'danhMucs'));
    }

    public function edit($id)
    {
        $sanPham = SanPham::findOrFail($id);
        $danhMucs = DanhMucSanPham::all();
        return view('admin.san-pham.edit', compact('sanPham', 'danhMucs'));
    }

    public function update(SanPhamRequest $request, $id)
    {
        try {
            $sanPham = SanPham::findOrFail($id);
            $data = $request->all();

            if ($request->hasFile('anh')) {
                if ($sanPham->anh && File::exists(public_path($sanPham->anh))) {
                    File::delete(public_path($sanPham->anh));
                }

                $danhMuc = DanhMucSanPham::findOrFail($request->danhmuc_id);
                $folder = 'img/' . $danhMuc->ten_danh_muc;

                if (!File::exists(public_path($folder))) {
                    File::makeDirectory(public_path($folder), 0755, true);
                }

                $file = $request->file('anh');
                $filename = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($folder), $filename);
                $data['anh'] = $folder . '/' . $filename;
            }

            $sanPham->update($data);

            return redirect()->route('sanPham.index')->with('success', 'Sản phẩm đã được cập nhật!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Không thể cập nhật sản phẩm: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $sanPham = SanPham::findOrFail($id);
        if ($sanPham->anh && File::exists(public_path($sanPham->anh))) {
            File::delete(public_path($sanPham->anh));
        }
        $sanPham->delete();

        return redirect()->route('sanPham.index')->with('success', 'Sản phẩm đã được xóa!');
    }
}