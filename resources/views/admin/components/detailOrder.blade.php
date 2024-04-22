<div style="background-color:rgba(0,0,0,0.3);" class="box top-0 start-0 end-0 bottom-0 position-fixed z-10">
    <div style="width:fit-content;height:fit-content;" class="position-relative bg-white m-auto rounded-4 py-2 px-4 mt-10">
        <div role="button" class="quit position-absolute top-0 end-0 mt-2 me-2">
            <i class="fa-solid fa-circle-xmark text-danger h3"></i>
        </div>
        <p class="text-black h6 p-4 fw-bold text-start border-bottom">CHI TIẾT ĐƠN HÀNG #{{$data->id_order}}</p>
        
        <div style="width:600px;max-height:600px;" class="overflow-y-auto">
            <p class="fw-bold text-success fs-6 my-2">THÔNG TIN</p>
            <table class="w-100">
                <tr class="text-start ">
                    <td class="fw-bold">Họ tên người nhận:</td>
                    <td>{{ $data->full_name }}</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold">Địa chỉ giao hàng:</td>
                    <td>{{ $data->address }}</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold">Số điện thoại:</td>
                    <td>{{ $data->phone }}</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold">Tạm tính:</td>
                    <td>{{ number_format($data->amount, 0, '', '.') }} đ</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold">Phí giao hàng:</td>
                    <td>{{ number_format($data->shipping_fee, 0, '', '.') }} đ</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold">Giảm giá:</td>
                    <td>{{ number_format($data->discountcost, 0, '', '.') }} đ</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold">Tổng thanh toán:</td>
                    <td>{{ number_format($data->total, 0, '', '.') }} đ</td>
                </tr>
            </table>
            <p class="fw-bold text-success fs-6 mb-2 mt-4">SẢN PHẨM</p>
            <table class="">
                <tr class="fw-bold">
                    <td class="">No.</td>
                    <td class="">Sản phẩm</td>
                    <td class="">Số lượng</td>
                    <td class="">Đơn giá</td>
                </tr>
                @foreach ($order->orderdetail as $detail)
                <tr class="">
                    <td class="">{{ $loop->index + 1 }}</td>
                    <td class="">{{ $detail->product->product_name }}</td>
                    <td class="">{{ $detail->quantity }}</td>
                    <td class="">{{ number_format($detail->product->newprice, 0, '', '.') }} đ</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>