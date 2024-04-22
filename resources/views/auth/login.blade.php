@extends('layouts.none')
@section('title', 'Đăng nhập')

@section('content')
<div style="width:30%" class="m-auto bg-white shadow-lg rounded-4 p-8">
    <p class="fs-3 text-success text-center fw-bold ">ĐĂNG NHẬP</p>
    <p class="fs-6 text-gray-600 fst-italic text-center">Chào mừng đến với LOGO!</p>
    <form class="d-flex flex-column" method="post">
        <label for="email" class="fw-bold mt-2">Tài khoản <span class="text-danger">*</span></label>
        <input type="text" id="email" name="email" class="border border-1 rounded-3 my-2 p-2" required>
        <span class="error text-danger fs-xs">
        @error('email')
            {{ $message }}
        @enderror
        </span>

        <label for="password" class="fw-bold mt-2">Mật khẩu <span class="text-danger">*</span></label>
        <div class="position-relative">
            <input type="password" id="password" name="password" class="border border-1 rounded-3 my-1 p-2 w-100" required>
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
        <a href="{{ route('password.forgot') }}" class="text-end">Quên mật khẩu</a>

        <div class="">
            <a href="" class=""></a>
            <a href="" class=""></a>
        </div>

        <span class="error text-danger fs-xs">
        @error('login')
            {{ $message }}
        @enderror
        </span>
        <p class="fs-sm text-center mt-4">Bạn chưa có tài khoản? <a href="{{route('register')}}" class="text-danger fs-6">Đăng ký</a></p>
        <button type="submit" class="bg-success text-white fw-bold rounded-3 py-2 mt-1">ĐĂNG NHẬP</button>
        @csrf
        <span class="text-gray-700 mt-2 text-center">hoặc</span>
    </form>
    <a href="{{ route('facebook') }}" class="w-100 d-block bg-primary text-center text-decoration-none text-white fw-bold rounded-3 py-2 my-2">
    <i class="fa-brands fa-facebook fs-5 text-white"></i>&ensp;Đăng Nhập Bằng Facebook
    </a>
    <a href="{{ route('google') }}" class="w-100 d-block bg-danger text-center text-decoration-none text-white fw-bold rounded-3 py-2 my-2">
    <i class="fa-brands fa-google-plus-g fs-5 text-white"></i>&ensp;Đăng Nhập Bằng Google
    </a>

</div>
@endsection