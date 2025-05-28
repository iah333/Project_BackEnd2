@extends('layouts.app')
@section('content')
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <title>Danh Sách Địa Chỉ</title>
    </head>

    <body>

        <div class="container mt-5">
            <h2>Danh Sách Địa Chỉ</h2>
            <a href="{{ route('dia-chi.create') }}" class="btn btn-primary mb-3">Thêm Địa Chỉ</a>
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
                                    <a href="{{ route('dia-chi.edit', $diaChi->id) }}"
                                        class="btn btn-warning btn-sm">Sửa</a>
                                    <form action="{{ route('dia-chi.destroy', $diaChi->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
@endsection

</html>
