<?php

namespace App\Http\Controllers;

use App\Models\DiaChi;
use App\Models\ThanhPho;
use App\Models\QuanHuyen;
use App\Models\PhuongXa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiaChiController extends Controller
{
    public function index()
    {
        $diaChis = Auth::user()->diaChis()->with(['thanhPho', 'quanHuyen', 'phuongXa'])->get();
        $thanhPhos = ThanhPho::all(); 
        return view('dia-chi.index', compact('diaChis','thanhPhos'));
    }

    public function create()
    {
        $thanhPhos = ThanhPho::all();
        return view('dia-chi.create', compact('thanhPhos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'thanh_pho_id' => 'required|exists:thanh_pho,id',
            'quan_huyen_id' => 'required|exists:quan_huyen,id',
            'phuong_xa_id' => 'required|exists:phuong_xa,id',
            'dia_chi_chi_tiet' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
        ]);

        DiaChi::create([
            'user_id' => Auth::id(),
            'thanh_pho_id' => $request->thanh_pho_id,
            'quan_huyen_id' => $request->quan_huyen_id,
            'phuong_xa_id' => $request->phuong_xa_id,
            'dia_chi_chi_tiet' => $request->dia_chi_chi_tiet,
            'so_dien_thoai' => $request->so_dien_thoai,
        ]);

        return redirect()->route('dia-chi.index')->with('success', 'Địa chỉ đã được lưu thành công!');
    }

    public function edit($id)
    {
        $diaChi = DiaChi::where('user_id', Auth::id())->findOrFail($id);
        $thanhPhos = ThanhPho::all();
        return view('dia-chi.edit', compact('diaChi', 'thanhPhos'));
    }

    public function update(Request $request, $id)
    {
        $diaChi = DiaChi::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'thanh_pho_id' => 'required|exists:thanh_pho,id',
            'quan_huyen_id' => 'required|exists:quan_huyen,id',
            'phuong_xa_id' => 'required|exists:phuong_xa,id',
            'dia_chi_chi_tiet' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
        ]);

        $diaChi->update([
            'thanh_pho_id' => $request->thanh_pho_id,
            'quan_huyen_id' => $request->quan_huyen_id,
            'phuong_xa_id' => $request->phuong_xa_id,
            'dia_chi_chi_tiet' => $request->dia_chi_chi_tiet,
            'so_dien_thoai' => $request->so_dien_thoai,
        ]);

        return redirect()->route('dia-chi.index')->with('success', 'Địa chỉ đã được cập nhật thành công!');
    }

    public function destroy($id)
    {
        $diaChi = DiaChi::where('user_id', Auth::id())->findOrFail($id);
        $diaChi->delete();

        return redirect()->route('dia-chi.index')->with('success', 'Địa chỉ đã được xóa thành công!');
    }

    public function getQuanHuyen($thanhPhoId)
    {
        $quanHuyens = QuanHuyen::where('thanh_pho_id', $thanhPhoId)->get();
        return response()->json($quanHuyens);
    }

    public function getPhuongXa($quanHuyenId)
    {
        $phuongXas = PhuongXa::where('quan_huyen_id', $quanHuyenId)->get();
        return response()->json($phuongXas);
    }
}