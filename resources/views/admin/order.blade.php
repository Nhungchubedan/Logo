@extends('layouts.admin')
@section('title', 'Quản lý đơn hàng')
@section('content')

<div class="admin-content">
    <p class="fw-bold text-success fs-4">DANH SÁCH ĐƠN HÀNG</p>
    <div class="d-flex justify-content-start position-relative mb-2 mt-3">
        <input style="width:40%;" id="search" type="text" class="py-2 fs-sm px-10 rounded-3 border border-black" placeholder="Tìm kiếm đơn đặt hàng">
        <i class="fa-solid fs-6 fa-magnifying-glass text-black position-absolute start-0 mt-3 mx-3"></i>
    </div>
    <table class="" id="data-table">
        <thead>
            <tr class="head">
                <th>Mã đơn hàng</th>
                <th>Tên tài khoản</th>
                <th>Thời gian</th>
                <th>Phí vận chuyển</th>
                <th>Mã giảm</th>
                <th>Tổng</th>
                <th>Trạng thái</th>
                <th>Thanh toán</th>
                <th>Cập nhập</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $order)
            <tr>
                <td>{{ $order->id_order }}</td>
                <td>{{ $order->user->user_name }}</td>
                <td>{{ $order->order_time }}</td>
                <td>{{ number_format($order->shipping_fee, 0, '', '.') }} đ</td>
                <td>{{ $order->id_voucher ?? 'NULL' }}</td>
                <td>{{ number_format($order->total, 0, '', '.') }} đ</td>
                <td>{{ $order->order_status }}</td>
                <td>{{ $order->payment_status }}</td>
                <td>{{ $order->updated_at ?? 'NULL' }}</td>
                <td>
                    <form class="d-inline-block" method="post" action="{{ route('generate.pdf') }}">
                        @csrf
                        <input type="hidden" name="id_order" value="{{ $order->id_order }}">
                        <button class="bg-transparent" type="submit">    
                            <i class="fa-solid fa-file-pdf fs-6 text-danger"></i>
                        </button>
                    </form>&ensp;
                    @if ($order->order_status == 'Chờ xác nhận')
                    <div class="btn d-inline-block">
                        <i class="fa-solid fa-pencil fs-6 text-primary"></i>
                        @include('admin.components.crudOrder', ['data' => $order])
                    </div>&ensp;
                    @endif
                    <div class="btn">
                        <i class="fa-solid fa-circle-info fs-6 text-success"></i>
                        @include('admin.components.detailOrder', [
                            'data' => $order,
                        ])
                    </div>
                </td>
            </tr>
            @endforeach

        </tbody>

    </table>
</div>

@endsection