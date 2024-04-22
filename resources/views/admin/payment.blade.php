@extends('layouts.admin')
@section('title', 'Quản trị hệ thống')
@section('content')
<div class="admin-content">
    <p class="fw-bold text-success fs-4">DANH SÁCH GIAO DỊCH</p>
    <div class="d-flex justify-content-start position-relative  mb-2 mt-3">
        <input style="width:40%;" id="search" type="text" class="py-2 fs-sm px-10 rounded-3 border border-black" placeholder="Tìm kiếm giao dịch">
        <i class="fa-solid fs-6 fa-magnifying-glass text-black position-absolute start-0 mt-3 mx-3"></i>
    </div>
    <table class="" id="data-table">
        <thead>
            <tr class="head">
                <th>Mã thanh toán</th>
                <th>Mã đơn hàng</th>
                <th>Số tiền giao dịch</th>
                <th>Thời gian</th>
                <th>Phương thức thanh toán</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
            <tr>
                <td>{{ $row->id_payment }}</td>
                <td>{{ $row->id_order }}</td>
                <td>{{ $row->payment_amount }}</td>
                <td>{{ $row->payment_time ?? 'NULL' }}</td>
                <td>{{ $row->payment_method }}</td>
            </tr>
            @endforeach
        </tbody> 
            

    </table>
</div>


@endsection