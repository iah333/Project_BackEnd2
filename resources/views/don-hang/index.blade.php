@extends('layouts.client')

@section('title', 'Danh sách đơn hàng - PhoneStore')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Danh sách đơn hàng</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($donHangs->isEmpty())
            <p>Không có đơn hàng nào được đặt.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Trạng thái Thanh Toán</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donHangs as $donHang)
                        <tr>
                            <td>{{ $donHang->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($donHang->ngay_dat)->format('d/m/Y H:i:s') }}</td>
                            <td>{{ number_format($donHang->tong_tien, 0, ',', '.') }} VNĐ</td>
                            <td>{{ $donHang->trang_thai }}</td>
                            <td>{{ $donHang->trang_thai_thanh_toan }}</td>

                            <td>
                                <a href="{{ route('don-hang.show', $donHang->id) }}" class="btn btn-info btn-sm">Xem chi tiết</a>
                                @if ($donHang->trang_thai_thanh_toan == 'chưa thanh toán')
                                    <a href="{{ route('don-hang.thanh-toan', $donHang->id) }}" class="btn btn-primary btn-sm">Thanh toán</a>
                                    <form action="{{ route('don-hang.destroy', $donHang->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection