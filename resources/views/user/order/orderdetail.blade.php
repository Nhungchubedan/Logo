@extends('layouts.user')
@section('title', 'Quản lý đơn hàng')
@section('link', 'Quản lý đơn hàng')
@section('content')
@if (isset($order))

<div style="min-height: 70vh;" class="d-flex">
    @include('components.sidebar', ['active' => 'order'])
    <div style="width:80%;" class="px-6">
        <p class="px-4 h4 fw-bold">
            <a href="{{ route('order') }}" class="text-decoration-none"><i class="fa-solid fa-chevron-left"></i></a>
            CHI TIẾT ĐƠN HÀNG
        </p>
        <p class="px-4 fs-6 fst-italic">ID: {{ $order->id_order }}</p>
       
        <ul class="list-unstyled m-4 border border-1 overflow-hidden rounded-3">
            <li class="fs-6 d-flex flex-nowrap bg-light p-2 justify-content-between">
                <div class="px-2">
                    <p class="fw-bold">Người nhận <span class="fw-light">{{ $order->full_name }}</span></p>
                    <p class="fw-bold">Số diện thoại <span class="fw-light">{{ $order->phone }}</span></p>
                    <p class="fw-bold">Ngày đặt <span class="fw-light">{{ $order->order_time }}</span></p>
                </div>
                <div class="px-2">
                    <p class="fw-bold">Địa chỉ nhận hàng</p>
                    <p class="">{{ $order->address }}</p>
                </div>
                
                <div class="px-2">
                    <p class="fw-bold">Phương thức thanh toán</p>
                    <p class="">{{ $order->payment->payment_method }}</p>
                    <p class="fw-bold">Trạng thái đơn hàng</p>
                    <p class="">{{ $order->order_status }}</p>
                </div>
                
            </li>
            <table class="w-100 text-center">
                <tr class="border bg-success">
                    <td style="" class="text-white">Sản phẩm</td>
                    <td style="width:10%;" class="text-white">Đơn giá</td>
                    <td style="width:10%;" class="text-white">Số lượng</td>
                    <td style="width:15%;" class="text-white">Tạm tính</td>
                </tr>
                @foreach ($order->orderdetail as $detail)
                <tr class="border w-100">
                    <td style="" class="d-flex p-2">
                        <img 
                            src="{{ asset('img/'. $detail->product->details->image->image_url ) }}" 
                            style="aspect-ratio: 1 / 1;width:120px;"
                            class="object-fit-cover"
                        >
                        <div class="flex-fill ps-2 text-start">
                            <p class="fs-6 text-success text-uppercase fw-bold">{{ $detail->product->brand->brand_name }}</p>
                            <p>{{ $detail->product->product_name }}</p>
                        </div>
                    </td>
                    <td style="width:10%;" class="">{{ number_format($detail->product->newprice,0,"",",") }} đ</td>
                    <td style="width:10%;" class="">{{ $detail->quantity }}</td>
                    <td style="width:15%;" class="">{{ number_format($detail->product->newprice * $detail->quantity,0,"",",") }} đ</td>
                </tr>
                @endforeach
            </table>
            <li class="fs-6 d-flex text-end flex-nowrap bg-light p-2 justify-content-end">
                
                <div class="">
                    <p class="">Tạm tính</p>
                    <p class="">Phí vận chuyển</p>
                    <p class="">Giảm giá</p>
                    <p class="mt-3 fw-bold">Thành tiền</p>
                </div>

                <div class="ms-10">
                    <p class="">{{ number_format($order->amount,0,"",",") }} đ</p>
                    <p class="">+ {{ number_format($order->shipping_fee,0,"",",") }} đ</p>
                    <p class="">- {{ number_format($order->discountcost,0,"",",") }} đ</p>
                    <p class="mt-2 fs-5 fw-bold text-warning">{{ number_format($order->total, 0, "", ",") }} đ</p>
                </div>
                
            </li>
        </ul>
    </div>

@endif
@endsection
