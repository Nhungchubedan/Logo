@extends('layouts.admin')
@section('title', 'Quản lý đánh giá')
@section('content')

<div class="admin-content">
    <p class="fw-bold text-success fs-4">DANH SÁCH ĐÁNH GIÁ SẢN PHẨM</p>
    <div class="d-flex justify-content-start position-relative mb-2 mt-3">
        <input style="width:40%;" id="search" type="text" class="py-2 fs-sm px-10 rounded-3 border border-black" placeholder="Tìm kiếm đánh giá của khách hàng">
        <i class="fa-solid fs-6 fa-magnifying-glass text-black position-absolute start-0 mt-3 mx-3"></i>
    </div>
    <table class="" id="data-table">
        <thead>
            <tr class="head">
                <th>Mã đánh giá</th>
                <th>Tên khách hàng</th>
                <th>Mã đơn hàng</th>
                <th>Sản phẩm</th>
                <th>Đánh giá</th>
                <th>Nội dung</th>
                <th>Đăng tải</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $rating)
            <tr class="text-center align-items-center border-bottom py-2 list-unstyled m-0 d-flex fs-xs text-black">
                <td>{{ $rating->id_rating }}</td>
                <td>{{ $rating->user->user_name }}</td>
                <td>{{ $rating->orderdetail->id_order }}</td>
                <td>{{ $rating->orderdetail->product->product_name }}</td>
                <td>{{ $rating->rating }}/5</td>
                <td>{{ $rating->review ?? 'NULL' }}</td>
                <td>{{ $rating->created_at }}</td>
                <td>
                    <div class="btn d-inline-block">
                        <i class="fa-solid fa-comment-dots fs-6 text-primary"></i>
                        @include('admin.components.reply', ['data' => $rating])
                    </div>&ensp;
                    <div class="btn">
                        <i class="fa-solid fa-circle-info fs-6 text-success"></i>
                        @include('admin.components.detailRating', [
                            'data' => $rating,
                        ])
                    </div>
                    
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>

@endsection