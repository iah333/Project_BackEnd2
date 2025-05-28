document.addEventListener('DOMContentLoaded', () => {
    // Xử lý cập nhật số lượng giỏ hàng
    const cartItems = document.querySelectorAll('.cart-quantity');
    const prices = {};

    @foreach ($cartItems as $item)
        prices['{{ $item->id }}'] = {{ $item->gia }};
    @endforeach

    cartItems.forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.closest('form').dataset.cartItem;
            const quantity = parseInt(this.value) || 1;
            const price = prices[itemId] || 0;
            const totalElement = document.querySelector(`[data-total="${itemId}"]`);
            const total = price * quantity;

            // Cập nhật tổng giá cho sản phẩm
            totalElement.textContent = new Intl.NumberFormat('vi-VN').format(total) + ' VNĐ';

            // Cập nhật tổng cộng giỏ hàng
            let cartTotal = 0;
            document.querySelectorAll('.cart-quantity').forEach(input => {
                const id = input.closest('form').dataset.cartItem;
                const qty = parseInt(input.value) || 1;
                cartTotal += (prices[id] || 0) * qty;
            });
            document.getElementById('cart-total').textContent = new Intl.NumberFormat('vi-VN').format(cartTotal) + ' VNĐ';
        });
    });

    // Xử lý animation khi submit form
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.classList.add('animate-pulse');
                setTimeout(() => submitButton.classList.remove('animate-pulse'), 1000);
            }
        });
    });
});
