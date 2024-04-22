@extends('layouts.none')
@section('title', 'Đăng ký')
@section('content')
<div style="width:40%;height:600px;" class="m-auto bg-white shadow-lg rounded-4 p-8 overflow-y-scroll">
    <p class="fs-3 text-success text-center fw-bold ">ĐĂNG KÝ</p>
    <p class="fs-6 text-gray-600 fst-italic text-center">
        Bạn đã là thành viên của LOGO?
        <a href="{{route('login')}}" class="text-danger">Đăng nhập ngay</a>
    </p>
    <form action="{{route('register')}}" class="d-flex flex-column" method="post">
        @csrf
        <label class="fw-bold mt-2">Tên tài khoản <span class="text-danger">*</span></label>
        <input type="text" name="account_name" class="border border-1 rounded-3 my-1 p-2">
        <span class="error text-danger fs-xs">
        @error('account_name')
            {{ $message }}
        @enderror
        </span>
        
        <label class="fw-bold mt-2">Email <span class="text-danger">*</span></label>
        <div class="position-relative">
            <input type="text" id="email" name="email" class="border border-1 rounded-3 my-1 p-2 w-100" required>
            <p id="otp" role="button" class="fs-sm fw-bold text-success position-absolute top-0 right-0 me-2 mt-4">GỬI MÃ</p>
        </div>
        <span id="otp-info" class="text-warning fs-xs"></span>
        <span class="error text-danger fs-xs">
        @error('email')
            {{ $message }}
        @enderror
        </span>
        
        <label class="fw-bold mt-2">Mã xác thực <span class="text-danger">*</span></label>
        <input type="text" name="otp" class="border border-1 rounded-3 my-1 p-2">
        <span class="error text-danger fs-xs">
        @error('otp')
            {{ $message }}
        @enderror
        @error('otp-info')
            {{ $message }}
        @enderror
        </span>

        <label  class="fw-bold mt-2">Mật khẩu <span class="text-danger">*</span></label>
        <div class="position-relative">
            <input type="password" name="password" class="border border-1 rounded-3 my-1 p-2 w-100"> 
            <span class="toggle-password position-absolute top-0 end-0 mt-4 me-2" role="button">
                <i class="fa-solid fa-eye eye fs-5 text-gray-600"></i>
                <i class="fa-solid fa-eye-slash eye-slash fs-5 text-gray-600"></i>
            </span>
        </div>
        <span class="error text-danger fs-xs">
        @error('password')
            {{ $message }}
        @enderror
        </span>

        <label class="fw-bold mt-2">Nhập lại mật khẩu <span class="text-danger">*</span></label>
        <div class="position-relative">
            <input type="password" name="password_confirm" class="border border-1 rounded-3 my-1 p-2 w-100">
            <span class="toggle-password position-absolute top-0 end-0 mt-4 me-2" role="button">
                <i class="fa-solid fa-eye eye fs-5 text-gray-600"></i>
                <i class="fa-solid fa-eye-slash eye-slash fs-5 text-gray-600"></i>
            </span>
        </div>
        <span class="error text-danger fs-xs">
        @error('password_confirm')
            {{ $message }}
        @enderror
        </span>
        
        <div class="d-flex mt-4">
            <input type="checkbox" id="agree" name="agree" value="agree" required>
            <label class="ms-1 text-start fs-sm fst-italic" for="agree">Tôi đã đọc và đồng ý với Điều khoản và Chính sách của LOGO</label>
        </div>

        <span class="error text-danger fs-xs">
        @error('fail')
            {{ $message }}
        @enderror
        </span>
        <button type="submit" class="bg-success text-white fw-bold rounded-3 py-2 mt-1">ĐĂNG KÝ</button>
    </form>
</div>
@endsection

@push('script')
<script type="text/javascript" src="{{ asset ('js/otp.js') }}"></script>
@endpush