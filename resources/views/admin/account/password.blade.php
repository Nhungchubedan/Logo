@extends('layouts.admin')
@section('title', 'Quản lý tài khoản')
@section('content')

    <div class="admin-content">
        <div style="width:80%;" class="">
            <div class="d-flex align-items-center">
            <a href="{{ route('admin.setting') }}" class="text-decoration-none fs-4 text-success">
                <i class="fa-solid fa-chevron-left"></i>
            </a>&ensp;
            <p class="fw-bold text-success fs-4">ĐỔI MẬT KHẨU</p>
        </div>
                
            <form action="" method="post" class="mt-6 w-75">
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

                <div class="mt-2 d-flex text-white fw-bold fs-6 w-100 justify-content-between">
                    <a href="{{ route('admin.setting') }}" style="width:45%;" class="p-2 rounded-2 text-center text-decoration-none bg-black">HỦY</a>
                    <button type="submit" style="width:45%;" class="text-white fw-bold fs-6 rounded-2 bg-success">CẬP NHẬP</a>
                </div>
            </form>
                
        </div>
    </div>

@endsection