@extends('layouts.admin')
@section('title', 'Quản trị hệ thống')
@section('content')

<div class="admin-content">
    <p class="fw-bold text-success fs-4">DANH SÁCH MÃ GIẢM GIÁ</p>
    <div class="d-flex justify-content-between position-relative mb-2 mt-3">
        <input style="width:40%;" id="search" type="text" class="py-2 fs-sm px-10 rounded-3 border border-black" placeholder="Tìm kiếm voucher">
        <i class="fa-solid fs-6 fa-magnifying-glass text-black position-absolute start-0 mt-3 mx-3"></i>
        <button class="btn fs-sm fw-bold text-white bg-success p-2 rounded-2 float-end">
            <i class="fa-solid fa-plus"></i> Thêm
        </button>
        @include('admin.components.crudVoucher', ['action' => 'add'])
    </div>
    <table class="" id="data-table">
        <thead>
            <tr class="head">
                <th>Mã giảm giá</th>
                <th>Tên chương trình</th>
                <th>Giảm (%)</th>
                <th>Tối đa</th>
                <th>Ngày bắt đầu</th>
                <th>Ngày kết thúc</th>
                <th>Cập nhập</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $voucher)
            <tr class="text-center align-items-center border-bottom py-2 list-unstyled m-0 d-flex fs-xs text-black">
                <td>{{ $voucher->id_voucher }}</td>
                <td>{{ $voucher->voucher_name }}</td>
                <td>{{ $voucher->voucher_value }}</td>
                <td>{{ $voucher->max == null ? 'Không giới hạn' : number_format($voucher->max, 0, '', '.').' đ' }}</td>
                <td>{{ $voucher->start_date }}</td>
                <td>{{ $voucher->end_date }}</td>
                <td>{{ $voucher->updated_at }}</td>
                <td>
                    <div class="btn d-inline-block">
                        <i class="fa-solid fa-pencil fs-6 text-primary"></i>
                        @include('admin.components.crudVoucher', [
                            'data'      => $voucher,
                            'action'    => 'update',
                            'date'      => $date,
                            'no'     => $index,
                        ])
                    </div>&ensp;
                    <div role="button" class="btn-confirm d-inline-block">
                        <i class="fa-solid fa-trash fs-6 text-danger"></i>
                        <form class="confirm-dialog" method="post">
                            @csrf
                            <input type="hidden" name="id_voucher" value="{{ $voucher->id_voucher }}">
                            <div class="dialog rounded-3 relative text-start">
                                <i class="fa-solid fa-xmark quit-dialog"></i>
                                <h4 class="fs-5 fw-bold w-100 text-danger">Xác nhận</h4>
                                <p class="text-black fs-6">Bạn có chắc chắn muốn xóa bản ghi này?</p>
                                <div class="mt-4 float-end">
                                    <button type="submit" name="action" value="delete" class="px-4 py-2 text-white fw-bold bg-danger rounded-5 fs-sm" name="cancel-order">XÁC NHẬN</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>

    </div>
</div>

@endsection