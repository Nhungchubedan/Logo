@extends('layouts.user')
@section('title', 'Cài đặt tài khoản')
@section('link', 'Cài đặt tài khoản')
@section('content')

    <div style="min-height: 70vh;" class="d-flex">

        @include('components.sidebar', ['active' => 'account'])

        <div style="width:80%;" class="px-6">
            <p class="px-4 h4 mb-4 fw-bold">
                <a href="{{ route('account') }}" class="text-decoration-none"><i class="fa-solid fa-chevron-left"></i></a>
                ĐỔI MẬT KHẨU
            </p>

            <!-- Thông tin tài khoản -->
            <div class="w-75 ps-4 py-4">
                <form action="" method="post">
                    @csrf
                    <div class="w-100 mb-6">
                        <label class="w-100 fs-6 fw-bold text-black">Mật khẩu cũ <span class="text-danger">*</span></label>
                        <input type="password" class="p-3 rounded-3 mt-1 w-100 border border-1" name="current_password" value="" required/>
                        <span class="error text-danger fs-xs">
                        @error('current_password')
                            {{ $message }}
                        @enderror
                        </spn>
                    </div>

                    <div class="w-100 mb-6">
                        <label class="w-100 fw-bold fs-6 text-black">Mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" class="p-3 rounded-3 mt-1 w-100 border border-1" name="new_password" value="" required/>
                        <span class="error text-danger fs-xs">
                        @error('new_password')
                            {{ $message }}
                        @enderror
                        </span>
                    </div>

                    <div class="w-100 mb-6">
                        <label class="w-100 fw-bold fs-6 text-black">Nhập lại mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="p-3 rounded-3 mt-1 w-100 border border-1" name="new_password_confirmation" value="" required/>
                        <span class="error text-danger fs-xs">
                        @error('new_password_confirmation')
                            {{ $message }}
                        @enderror
                        </span>
                    </div>
                    
                    <div class="w-100 text-end">
                        <a href="{{ route('password.forgot') }}" class="text-danger">Quên mật khẩu ?</a>
                    </div>

                    <div class="p-2 d-flex text-white fw-bold fs-6 w-100 justify-content-around">
                        <a href="{{ route('account') }}" style="width:40%;" class="p-2 rounded-4 text-center text-decoration-none bg-black">HỦY</a>
                        <button type="submit" style="width:40%;" class="text-white fw-bold fs-6  rounded-4 bg-success">CẬP NHẬP</a>
                    </div>
                </form>
            </div>
                
        </div>
    </div>



@endsection