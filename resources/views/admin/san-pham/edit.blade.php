@extends('layouts.admin')

  @section('content')
  <div class="card shadow-sm">
      <div class="card-header">
          <h5>Sửa sản phẩm</h5>
      </div>
      <div class="card-body">
          <form action="{{ route('sanPham.update', $sanPham->ma_san_pham) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <div class="mb-3">
                  <label for="ma_danh_muc" class="form-label">Danh mục</label>
                  <select name="ma_danh_muc" id="ma_danh_muc" class="form-control">
                      @foreach ($danhMucs as $danhMuc)
                          <option value="{{ $danhMuc->ma_danh_muc }}" {{ $danhMuc->ma_danh_muc == $sanPham->ma_danh_muc ? 'selected' : '' }}>
                              {{ $danhMuc->ten_danh_muc }}
                          </option>
                      @endforeach
                  </select>
                  @error('ma_danh_muc')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
              <div class="mb-3">
                  <label for="ten_san_pham" class="form-label">Tên sản phẩm</label>
                  <input type="text" name="ten_san_pham" id="ten_san_pham" class="form-control" value="{{ old('ten_san_pham', $sanPham->ten_san_pham) }}">
                  @error('ten_san_pham')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
              <div class="mb-3">
                  <label for="gia" class="form-label">Giá</label>
                  <input type="number" name="gia" id="gia" class="form-control" value="{{ old('gia', $sanPham->gia) }}" step="0.01">
                  @error('gia')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
              <div class="mb-3">
                  <label for="so_luong_ton" class="form-label">Số lượng tồn</label>
                  <input type="number" name="so_luong_ton" id="so_luong_ton" class="form-control" value="{{ old('so_luong_ton', $sanPham->so_luong_ton) }}">
                  @error('so_luong_ton')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
              <div class="mb-3">
                  <label for="anh" class="form-label">Ảnh sản phẩm</label>
                  <input type="file" name="anh" id="anh" class="form-control">
                  @if ($sanPham->anh)
                      <img src="{{ asset('storage/' . $sanPham->anh) }}" alt="{{ $sanPham->ten_san_pham }}" style="width: 100px; margin-top: 10px;">
                  @endif
                  @error('anh')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
              <button type="submit" class="btn btn-primary">Cập nhật</button>
              <a href="{{ route('sanPham.index') }}" class="btn btn-secondary">Hủy</a>
          </form>
      </div>
  </div>
  @endsection