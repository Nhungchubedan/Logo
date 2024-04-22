@extends('layouts.admin')
@section('title', 'Quản lý tài khoản')
@section('content')

    <div class="admin-content">
        <div style="width:80%;" class="">

        <div class="d-flex align-items-center">
            <a href="{{ route('admin.setting') }}" class="text-decoration-none fs-4 text-success">
                <i class="fa-solid fa-chevron-left"></i>
            </a>&ensp;
            <p class="fw-bold text-success fs-4">SỬA THÔNG TIN</p>
        </div>

        <form action="" method="post" enctype="multipart/form-data" class="mt-6 w-75">
            @csrf
            <div class="float-end position-relative rounded-6  rounded-circle overflow-hidden" style="width:130px;height:130px;">
                <img src="{{ asset('img/'.$account->image->image_url) }}" 
                    id="avatar-img"
                    class="w-100 h-100 rounded-circle object-fit-cover"
                >
                <label for="avatar-input" role="button" class="position-absolute w-100 text-center bottom-0 start-0 bg-black opacity-75 ">
                    <i class="fa-solid fa-camera py-1 fs-5 text-white"></i>
                </label>
                <input type="file" id="avatar-input" name="avatar" accept="image/*" value="" hidden>
            </div>

            <div class="w-75 mb-6">
                <label class="w-100 fs-6 fw-bold text-black">Tên tài khoản <span class="text-danger">*</span></label>
                <input type="text" class="p-3 rounded-3 mt-1 w-100 border border-1" name="username" value="{{ $account->user_name }}" required/>
                <span class="error text-danger fs-xs">
                @error('username')
                    {{ $message }}
                @enderror
                </span>
            </div>

            <div class="w-75 mb-6">
                <label class="w-100 fw-bold fs-6 text-black">Email <span class="text-danger">*</span></label>
                <input type="text" class="p-3 rounded-3 mt-1 w-100 border border-1" name="email" value="{{ $account->email }}" required/>
                <span class="error text-danger fs-xs">
                @error('email')
                    {{ $message }}
                @enderror
                @error('isExisted')
                    {{ $message }}
                @enderror
                </span>
            </div>

            <div class="w-100 mb-6">
                <label class="w-100 fw-bold fs-6 text-black">Mật khẩu xác thực <span class="text-danger">*</span></label>
                <input type="password" class="p-3 rounded-3 mt-1 w-100 border border-1" name="password" required/>
                <span class="error text-danger fs-xs">
                @error('password')
                    {{ $message }}
                @enderror
                </span>
            </div>

            <div class="p-2 d-flex text-white fw-bold fs-6 w-100 justify-content-between">
                <a href="{{ route('account') }}" style="width:45%;" class="p-2 rounded-2 text-center text-decoration-none bg-black">HỦY</a>
                <button type="submit" style="width:45%;" class="text-white fw-bold fs-6  rounded-2 bg-success">LƯU</a>
            </div>
        </form>
                
    </div>
@endsection

@push('script')
<script type="text/javascript" src="{{ asset ('js/index.js') }}"></script>

@endpush