@extends('layouts.user')
@section('title', 'Cài đặt tài khoản')
@section('link', 'Cài đặt tài khoản')
@section('content')

@if (isset($account))
    <div style="min-height: 70vh;" class="d-flex">

        @include('components.sidebar', ['active' => 'account'])

        <div style="width:80%;" class="px-6">
            <p class="px-4 h4 mb-4 fw-bold">CÀI ĐẶT TÀI KHOẢN</p>
            <div class="d-flex">

                <!-- Thông tin tài khoản -->
                <div class="w-50 px-2">
                    <ul class="p-2 list-unstyled rounded-3 border">
                        <li class="fw-bold text-black border-bottom p-2">Thông tin tài khoản</li>
                        <li class="p-2 d-flex">
                            @if (isset($account->image))
                            <img src="{{ asset('img/'.$account->image->image_url) }}" 
                                alt="Avatar"
                                role="button"
                                style="width:50px;height:50px"
                                class="rounded-circle object-fit-cover me-3"
                            >
                            @else
                            <img src="{{ $account->image_link }}" 
                                alt="Avatar"
                                role="button"
                                style="width:50px;height:50px"
                                class="rounded-circle object-fit-cover me-3"
                            >
                            @endif

                            <div class="flex-fill text-start">
                                <p class="fs-6 fw-bold text-black">{{ $account->user_name }}</p>
                                <p class="fst-italic fs-sm"><span class="fw-bold">ID:</span> {{ $account->id_user }}</p>
                            </div>
                        </li>
                        <li class="p-2 "><span class="fw-bold">Email: </span>{{ $account->email }}</li>
                        @if ($account->provider == 'System')
                        <li class="p-2 d-flex justify-content-between">
                            <a href="{{ route('account.modify') }}">Chỉnh sửa</a>
                            <a href="{{ route('account.password') }}" class="text-danger">Đổi mật khẩu</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="w-50 px-2">
                    <ul class="p-2 list-unstyled rounded-3 border">
                        <li class="fw-bold text-black border-bottom p-2">Địa chỉ giao hàng</li>
                        @if (isset($account->info)) 
                            <li class="fs-6 fw-bold d-flex align-items-center p-2">
                                <span>{{ $account->info->full_name }}</span> 
                                &ensp;<i class="fa-solid fa-circle-dot fs-xs"></i>&ensp;
                                <span> {{ $account->info->phone }}</span> 
                            </li>
                            <li class="p-2">
                                {{ $account->info->detail_address }}, 
                                {{ $account->info->commune }}, 
                                {{ $account->info->district }}, 
                                {{ $account->info->province }}
                            </li>
                            <li class="p-2 w-100 text-end text-danger">
                                <a href="{{ route('account.info') }}">Chỉnh sửa</a>
                            </li>
                        @else
                            <li class="mt-4 p-2">
                                Bạn chưa có địa chỉ giao hàng mặc định
                            </li>
                            <li class="p-2 w-100 text-end text-danger">
                                <a href="{{ route('account.info') }}">Thêm</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div> 
        </div>
    </div>


@endif

@endsection