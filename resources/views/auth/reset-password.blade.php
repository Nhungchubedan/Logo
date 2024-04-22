@extends('layouts.none')
@section('title', 'Thay đổi mật khẩu')

@section('content')
    <div style="width:500px;" class="m-auto bg-white shadow-lg rounded-4 p-8">
        <!-- reset.blade.php -->
        <form method="POST" action="">
            @csrf

            <a href="{{route('welcome')}}" class="text-reset text-center w-100 text-decoration-none">
                <h1 class="mb-4 text-success">L O G O</h1>
            </a>

            <div class="mt-4">
                <label class="w-100 fs-sm text-black fw-bold mb-1">Mật khẩu mới</label>
                <input type="password" name="password" class="w-100 border p-2" required>
                <span class="error text-danger fs-xs">
                @error('password')
                    {{ $message }}
                @enderror
                </span>
            </div>

            <div class="mt-4"> 
                <label class="w-100 fs-sm text-black fw-bold mb-1">Nhập lại mật khẩu mới</label>
                <input type="password" class="w-100 border p-2" name="password_confirmation" required>
                <span class="error text-danger fs-xs">
                @error('password_confirmation')
                    {{ $message }}
                @enderror
                </span>
            </div>

            <div class="mt-4">
                <button type="submit" class=" px-6 py-2 rounded-2 float-end bg-black text-white text-center">Cập nhật mật khẩu</button>
            </div>
        </form>

    </div>
@endsection
