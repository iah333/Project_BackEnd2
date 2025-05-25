<h2>Giỏ hàng của bạn</h2>

@if ($gioHang && $gioHang->sanPhams->count() > 0)
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($gioHang->sanPhams as $sp)
                <tr>
                    <td>{{ $sp->TenSanPham }}</td>
                    <td><img src="{{ asset('storage/' . $sp->AnhSanPham) }}" width="50"></td>
                    <td>{{ number_format($sp->GiaSanPham, 0, ',', '.') }} VNĐ</td>
                    <td>{{ $sp->pivot->so_luong }}</td>
                    <td>{{ number_format($sp->GiaSanPham * $sp->pivot->so_luong, 0, ',', '.') }} VNĐ</td>
                    <td>
                        <form action="{{ route('giohang.xoa', $sp->id) }}" method="POST"
                            onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Giỏ hàng trống.</p>
@endif
