<?php

namespace App\Http\Controllers;

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

    public function create()
    {
        $danhMucs = DanhMucSanPham::all();
        return view('admin.san-pham.create', compact('danhMucs'));
    }

    public function store(Request $request)
{
    try {
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'gia' => 'required|numeric|min:0',
            'so_luong_ton' => 'required|integer|min:0',
            'danhmuc_id' => 'required|exists:danhmuc,id',
            'anh' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'danhmuc_id.exists' => 'Danh mục được chọn không tồn tại. Vui lòng chọn lại.',
        ]);

        $data = $request->all();
        if ($request->hasFile('anh')) {
            $danhMuc = DanhMucSanPham::findOrFail($request->danhmuc_id);
            // Chuẩn hóa tên thư mục: thay khoảng trắng bằng "-", loại bỏ ký tự đặc biệt
            $folderName = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $danhMuc->ten_danh_muc));
            $folder = 'img/' . $folderName;

            // Kiểm tra thư mục đã tồn tại
            if (!File::exists(public_path($folder))) {
                return back()->withErrors(['anh' => 'Thư mục ' . $folder . ' không tồn tại. Vui lòng kiểm tra lại thư mục danh mục.']);
            }

            $file = $request->file('anh');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path($folder), $filename);
            $data['anh'] = $folder . '/' . $filename;
        }

        SanPham::create($data);

        return redirect()->route('sanPham.index')->with('success', 'Sản phẩm đã được tạo!');
    } catch (\Exception $e) {
        \Log::error('Lỗi khi thêm sản phẩm: ' . $e->getMessage());
        return back()->withErrors(['error' => 'Không thể thêm sản phẩm: ' . $e->getMessage()]);
    }
}

    public function show($id)
    {
        \Log::info('SanPhamController@show called', ['user' => Auth::user(), 'id' => $id]);
        $sanPham = SanPham::with('danhMuc')->findOrFail($id);
        $danhMucs = DanhMucSanPham::all();

        if (Auth::check() && Auth::user()->is_admin) {
            \Log::info('User is admin, showing admin view');
            return view('admin.san-pham.show', compact('sanPham', 'danhMucs'));
        }

        \Log::info('User is not admin, showing chi-tiet view');
        return view('san-pham.chi-tiet', compact('sanPham'));
    }

    public function edit($id)
    {
        $sanPham = SanPham::findOrFail($id);
        $danhMucs = DanhMucSanPham::all();
        return view('admin.san-pham.edit', compact('sanPham', 'danhMucs'));
    }

    public function update(Request $request, $ma_san_pham)
{
    $request->validate([
        'ten_san_pham' => 'required|string|max:255',
        'gia' => 'required|numeric',
        'so_luong_ton' => 'required|integer',
        'danhmuc_id' => 'required|exists:danhmuc,id',
        'anh' => 'nullable|image|max:2048',
    ]);

    $sanPham = SanPham::findOrFail($ma_san_pham);
    $data = $request->all();
    if ($request->hasFile('anh')) {
        if ($sanPham->anh && File::exists(public_path($sanPham->anh))) {
            File::delete(public_path($sanPham->anh));
        }

        $danhMuc = DanhMucSanPham::findOrFail($request->danhmuc_id);
        // Chuẩn hóa tên thư mục: thay khoảng trắng bằng "-", loại bỏ ký tự đặc biệt
        $folderName = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $danhMuc->ten_danh_muc));
        $folder = 'img/' . $folderName;

        // Kiểm tra thư mục đã tồn tại
        if (!File::exists(public_path($folder))) {
            return back()->withErrors(['anh' => 'Thư mục ' . $folder . ' không tồn tại. Vui lòng kiểm tra lại thư mục danh mục.']);
        }

        $file = $request->file('anh');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path($folder), $filename);
        $data['anh'] = $folder . '/' . $filename;
    }

    $sanPham->update($data);

    return redirect()->route('sanPham.index')->with('success', 'Sản phẩm đã được cập nhật!');
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