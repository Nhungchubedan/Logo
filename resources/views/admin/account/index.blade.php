@extends('layouts.admin')
@section('title', 'Quản lý tài khoản')
@section('content')

    <div class="admin-content">
        <div style="width:80%;" class="">
            <p class="fw-bold text-success fs-4">CÀI ĐẶT TÀI KHOẢN</p>

            <div class="w-75 mt-6">
                <ul class="p-2 list-unstyled rounded-3 border">
                    <li class="fw-bold text-black border-bottom p-2">Thông tin tài khoản</li>
                    <li class="p-2 d-flex">
                        <img src="{{ asset('img/'.$account->image->image_url) }}" 
                            alt="Avatar"
                            role="button"
                            style="width:50px;height:50px"
                            class="rounded-circle object-fit-cover me-3"
                        >
                        <div class="flex-fill text-start">
                            <p class="fs-6 fw-bold text-black">{{ $account->user_name }}</p>
                            <p class="fst-italic fs-sm"><span class="fw-bold">ID:</span> {{ $account->id_user }}</p>
                        </div>
                    </li>
                    <li class="p-2 "><span class="fw-bold">Email: </span>{{ $account->email }}</li>
                    <li class="p-2 d-flex justify-content-between">
                        <a href="{{ route('admin.modify') }}">Chỉnh sửa</a>
                        <a href="{{ route('admin.password') }}" class="text-danger">Đổi mật khẩu</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection