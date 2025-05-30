@extends('layouts.app')

@section('title', 'Danh Sách Địa Chỉ - PhoneStore')

@section('content')
    <div class="container mt-5">
        <h2>Danh Sách Địa Chỉ</h2>
        <!-- Nút mở modal -->
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
            Thêm Địa Chỉ
        </button>

        @if ($diaChis->isEmpty())
            <p>Chưa có địa chỉ nào.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Thành Phố</th>
                        <th>Quận/Huyện</th>
                        <th>Phường/Xã</th>
                        <th>Địa Chỉ Chi Tiết</th>
                        <th>Số Điện Thoại</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diaChis as $diaChi)
                        <tr>
                            <td>{{ $diaChi->thanhPho->ten_thanh_pho }}</td>
                            <td>{{ $diaChi->quanHuyen->ten_quan_huyen }}</td>
                            <td>{{ $diaChi->phuongXa->ten_phuong_xa }}</td>
                            <td>{{ $diaChi->dia_chi_chi_tiet }}</td>
                            <td>{{ $diaChi->so_dien_thoai }}</td>
                            <td>
                                <a href="{{ route('dia-chi.edit', $diaChi->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="{{ route('dia-chi.destroy', $diaChi->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Modal thêm địa chỉ -->
        <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAddressModalLabel">Thêm Địa Chỉ Mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('dia-chi.store') }}" method="POST" id="diaChiForm">
                            @csrf
                            <div class="mb-3">
                                <label for="thanh_pho_id" class="form-label">Thành Phố</label>
                                <select name="thanh_pho_id" id="thanh_pho_id" class="form-control" required>
                                    <option value="">Chọn thành phố</option>
                                    @foreach ($thanhPhos as $thanhPho)
                                        <option value="{{ $thanhPho->id }}">{{ $thanhPho->ten_thanh_pho }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="quan_huyen_id" class="form-label">Quận/Huyện</label>
                                <select name="quan_huyen_id" id="quan_huyen_id" class="form-control" required>
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="phuong_xa_id" class="form-label">Phường/Xã</label>
                                <select name="phuong_xa_id" id="phuong_xa_id" class="form-control" required>
                                    <option value="">Chọn phường/xã</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="dia_chi_chi_tiet" class="form-label">Địa Chỉ Chi Tiết</label>
                                <input type="text" name="dia_chi_chi_tiet" id="dia_chi_chi_tiet" class="form-control" value="{{ old('dia_chi_chi_tiet') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="so_dien_thoai" class="form-label">Số Điện Thoại</label>
                                <input type="text" name="so_dien_thoai" id="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai') }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu Địa Chỉ</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#thanh_pho_id').change(function() {
                var thanhPhoId = $(this).val();
                if (thanhPhoId) {
                    $.get('/dia-chi/get-quan-huyen/' + thanhPhoId, function(data) {
                        var quanHuyenSelect = $('#quan_huyen_id');
                        quanHuyenSelect.empty();
                        quanHuyenSelect.append('<option value="">Chọn quận/huyện</option>');
                        $.each(data, function(index, quanHuyen) {
                            quanHuyenSelect.append('<option value="' + quanHuyen.id + '">' + quanHuyen.ten_quan_huyen + '</option>');
                        });
                        $('#phuong_xa_id').empty().append('<option value="">Chọn phường/xã</option>');
                    });
                }
            });

            $('#quan_huyen_id').change(function() {
                var quanHuyenId = $(this).val();
                if (quanHuyenId) {
                    $.get('/dia-chi/get-phuong-xa/' + quanHuyenId, function(data) {
                        var phuongXaSelect = $('#phuong_xa_id');
                        phuongXaSelect.empty();
                        phuongXaSelect.append('<option value="">Chọn phường/xã</option>');
                        $.each(data, function(index, phuongXa) {
                            phuongXaSelect.append('<option value="' + phuongXa.id + '">' + phuongXa.ten_phuong_xa + '</option>');
                        });
                    });
                }
            });
        });
    </script>
@endsection