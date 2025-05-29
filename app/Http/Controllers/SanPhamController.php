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
    // Xử lý tìm kiếm cho người dùng
    public function search(Request $request)
    {
        try {
            $search = $request->query('search');
            $ma_danh_muc = $request->query('ma_danh_muc');

            // Lấy tất cả danh mục để hiển thị trong menu
            $danhMucs = DanhMucSanPham::all();

            // Query sản phẩm
            $query = SanPham::query();

            // Nếu có từ khóa tìm kiếm
            if ($search) {
                $query->where('ten_san_pham', 'LIKE', "%{$search}%");
            }

            // Nếu có danh mục được chọn
            if ($ma_danh_muc) {
                $query->where('danhmuc_id', $ma_danh_muc);
                session(['current_category' => $ma_danh_muc]);
            } else {
                // Nếu có tìm kiếm, lấy danh mục của sản phẩm đầu tiên tìm thấy
                if ($search) {
                    $firstProduct = $query->first();
                    if ($firstProduct && $firstProduct->danhmuc_id) {
                        $ma_danh_muc = $firstProduct->danhmuc_id;
                        session(['current_category' => $ma_danh_muc]);
                    }
                }
            }

            // Lấy danh sách sản phẩm với phân trang
            $sanPhams = $query->with('danhMuc')->paginate(12);

            // Lấy thông tin giỏ hàng để hiển thị số lượng
            $tongSoLuong = session('tongSoLuong', 0);

            return view('san-pham.index', compact('sanPhams', 'danhMucs', 'tongSoLuong', 'ma_danh_muc', 'search'))
                ->with('success', session('success'));
        } catch (\Exception $e) {
            Log::error('Lỗi khi tìm kiếm sản phẩm: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Không thể tìm kiếm sản phẩm.');
        }
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
                // Giữ nguyên tên danh mục có dấu
                $folder = 'img/' . $danhMuc->ten_danh_muc;

                // Tự động tạo thư mục nếu chưa tồn tại
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
            // Giữ nguyên tên danh mục có dấu
            $folder = 'img/' . $danhMuc->ten_danh_muc;

            // Tự động tạo thư mục nếu chưa tồn tại
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
