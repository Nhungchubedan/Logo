@extends('layouts.order')
@section('title','Thanh toán')
@section('content')
<div id="pay" style="height:calc(100vh - 70px);" class="d-flex justify-content-center align-items-center w-100">
    <div style="width:500px;" class="overflow-hidden rounded-4 pt-8 pb-4 px-4 bg-white">
        <p class="h5 px-4 fw-bold text-black m-0">THÔNG TIN THANH TOÁN</p>
        <ul class="text-black px-4 m-0">
            <li class="my-6 d-flex justify-content-between align-items-center">
                <p class="fw-bold">Mã đơn hàng</p>
                <p class="text-gray-700 text-end">{{ $order->id_order }}</p>
                <input type="hidden" id="order-id" value="{{ $order->id_order }}"/>
            </li>
            <li class="my-6 d-flex justify-content-between align-items-center">
                <p class="fw-bold">Ngày đặt</p>
                <p class="text-gray-700 text-end">{{ $order->order_time }}</p>
            </li>
            <li class="my-6 d-flex justify-content-between align-items-center">
                <p class="fw-bold">Ngân hàng thụ hưởng</p>
                <p class="text-gray-700 text-end">Ngân hàng TMCP Đầu tư<br> và Phát triển Việt Nam (BIDV)</p>
            </li>
            <li class="my-6 d-flex justify-content-between align-items-center">
                <p class="fw-bold">Tài khoản thụ hưởng</p>
                <p class="text-gray-700 text-end">7620001589287<br>NGUYEN THI THUY VI</p>
            </li>
            <li class="my-6 d-flex justify-content-between align-items-center">
                <p class="fw-bold">Tổng thanh toán</p>
                <p class="text-success fw-bold fs-5 text-end">{{ number_format($order->total, 0, '', ',') }} đ</span>
                <input type="hidden" id="total" value="{{ $order->total }}" />
            </li>
            <li class="my-6 d-flex justify-content-between align-items-center">
                <p class="fw-bold">Trạng thái</p>
                <p id="status" class="fw-light fs-6 w-50 text-end text-capitalize"><span class="text-warning">chưa thanh toán</span></span>
            </li>
            <p id="end" class="text-center fs-sm">Vui lòng thanh toán trong <span class="count-down text-danger"></span></p>
        </ul>
    </div>
    <div style="width:360px;" class="ms-20 p-20 bg-white border border-5 border-success rounded-4">
        
        <img 
        src="" 
        id="qr"
        class="w-100 object-fit-cover"
        >
        
    </div>
</div>
@endsection 
@push('script')
<script type="text/javascript" src="{{ asset('js/pay.js') }}"></script>
@endpush