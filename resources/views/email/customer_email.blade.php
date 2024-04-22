@component('mail::message')
# Thông báo đặt hàng thành công

Xin chào {{ $order->user->user_name }},

Chúng tôi xin thông báo rằng đơn hàng của bạn đã được xác nhận và đang được xử lý thành công. Dưới đây là thông tin chi tiết về đơn hàng của bạn:

**Mã đơn hàng:** {{ $order->id_order }}

**Tổng giá trị đơn hàng:** {{ number_format($order->total, 0, ',', '.') }} VNĐ

**Phương thức thanh toán:** {{ $order->payment_method }}

**Phí vận chuyển:** {{ $order->shipping_fee }}

**Ngày đặt hàng:** {{ $order->order_time->format('d/m/Y H:i:s') }}

**Danh sách sản phẩm:**
@foreach ($order->orderdetail as $item)
- {{ $item->product->product_name }} ({{ $item->quantity }} x {{ number_format($item->product->newprice, 0, ',', '.') }} VNĐ)
@endforeach

Nếu bạn có bất kỳ câu hỏi nào về đơn hàng của mình, vui lòng liên hệ với chúng tôi qua email hoặc số điện thoại được cung cấp dưới đây.

Trân trọng,

{{ config('app.name') }} Team

@endcomponent
