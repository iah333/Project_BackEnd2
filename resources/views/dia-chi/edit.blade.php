<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Chỉnh Sửa Địa Chỉ</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Chỉnh Sửa Địa Chỉ</h2>

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

        <form action="{{ route('dia-chi.update', $diaChi->id) }}" method="POST" id="diaChiForm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="thanh_pho_id" class="form-label">Thành Phố</label>
                <select name="thanh_pho_id" id="thanh_pho_id" class="form-control" required>
                    <option value="">Chọn thành phố</option>
                    @foreach ($thanhPhos as $thanhPho)
                        <option value="{{ $thanhPho->id }}" {{ $diaChi->thanh_pho_id == $thanhPho->id ? 'selected' : '' }}>
                            {{ $thanhPho->ten_thanh_pho }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quan_huyen_id" class="form-label">Quận/Huyện</label>
                <select name="quan_huyen_id" id="quan_huyen_id" class="form-control" required>
                    <option value="">Chọn quận/huyện</option>
                    @foreach ($diaChi->thanhPho->quanHuyens as $quanHuyen)
                        <option value="{{ $quanHuyen->id }}" {{ $diaChi->quan_huyen_id == $quanHuyen->id ? 'selected' : '' }}>
                            {{ $quanHuyen->ten_quan_huyen }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="phuong_xa_id" class="form-label">Phường/Xã</label>
                <select name="phuong_xa_id" id="phuong_xa_id" class="form-control" required>
                    <option value="">Chọn phường/xã</option>
                    @foreach ($diaChi->quanHuyen->phuongXas as $phuongXa)
                        <option value="{{ $phuongXa->id }}" {{ $diaChi->phuong_xa_id == $phuongXa->id ? 'selected' : '' }}>
                            {{ $phuongXa->ten_phuong_xa }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="dia_chi_chi_tiet" class="form-label">Địa Chỉ Chi Tiết</label>
                <input type="text" name="dia_chi_chi_tiet" id="dia_chi_chi_tiet" class="form-control" value="{{ old('dia_chi_chi_tiet', $diaChi->dia_chi_chi_tiet) }}" required>
            </div>
            <div class="mb-3">
                <label for="so_dien_thoai" class="form-label">Số Điện Thoại</label>
                <input type="text" name="so_dien_thoai" id="so_dien_thoai" class="form-control" value="{{ old('so_dien_thoai', $diaChi->so_dien_thoai) }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật Địa Chỉ</button>
            <a href="{{ route('dia-chi.index') }}" class="btn btn-secondary">Quay Lại</a>
        </form>
    </div>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>