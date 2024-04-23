@extends('layouts.admin')
@section('title', 'Quản lý tài khoản')
@section('content')

<div class="admin-content">
    <p class="fw-bold text-success fs-4">DANH SÁCH TÀI KHOẢN</p>
    <div class="d-flex justify-content-between position-relative mb-2 mt-3">
        <input style="width:40%;" id="search" type="text" class="py-2 fs-sm px-10 rounded-3 border border-black" placeholder="Tìm kiếm tài khoản">
        <i class="fa-solid fs-6 fa-magnifying-glass text-black position-absolute start-0 mt-3 mx-3"></i>
        <button class="btn fs-sm fw-bold text-white bg-success p-2 rounded-2 float-end">
            <i class="fa-solid fa-plus"></i> Thêm
        </button>
        @include('admin.components.crudAccount', ['action' => 'add'])
    </div>
    <table id="data-table">
        <thead>
            <tr class="head">
                <th>Mã tài khoản</th>
                <th>Tên tài khoản</th>
                <th>Email</th>
                <th><i class="fa-solid fa-pencil fs-sm text-primary"></i>&ensp;Quyền truy cập</th>
                <th>Kích hoạt</th>
                <th>Ngày tạo</th>
                <th>Cập nhập</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $account)
            <tr class="">
                <td class="user">{{ $account->id_user }}</td>
                <td>{{ $account->user_name }}</td>
                <td style="word-break:break-all;">{{ $account->email }}</td>
                <td class="editable">{{ $account->role->role }}</td>
                <td>{{ $account->confirm }}</td>
                <td>{{ $account->created_at }}</td>
                <td>{{ $account->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
   
</div>

@endsection