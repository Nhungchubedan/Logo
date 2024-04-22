@extends('layouts.none')
@section('title', 'Quên mật khẩu')

@section('content')
    <div style="width:500px;" class="m-auto bg-white shadow-lg rounded-4 pt-8 px-8 pb-4">
        <a href="{{route('welcome')}}" class="text-reset text-center w-100 text-decoration-none">
            <h1 class="mb-4 text-success">L O G O</h1>
        </a>

        <div class="fs-sm text-gray-600">
        Quên mật khẩu? Không vấn đề. Chỉ cần cho chúng tôi biết địa chỉ email của bạn và 
        chúng tôi sẽ gửi cho bạn một liên kết đặt lại mật khẩu qua email, giúp bạn chọn một mật khẩu mới.
        </div>
        @if (session('status'))
        <div class="my-2 text-success fs-sm">
            {{ session('status') }}
        </div>
        @endif

        <form method="post" action="" class="mt-2">
            @csrf

            <!-- Email Address -->
            <div class="w-100">
                <input id="email" class="mt-2 w-100 border p-2" type="email" name="email" value="{{ old('email') }}" required autofocus />
                <span class="error text-danger fs-xs">
                @error('email')
                    {{ $message }}
                @enderror
                </span>
            </div>

            <button type="submit" class="w-100 mt-4 rounded-2 bg-black text-white p-2">
                Liên kết thay đổi mật khẩu
            <button>
        </form>
    </div>
@endsection
