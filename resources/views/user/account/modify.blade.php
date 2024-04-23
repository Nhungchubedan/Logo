@extends('layouts.user')
@section('title', 'Cài đặt tài khoản')
@section('link', 'Cài đặt tài khoản')
@section('content')
@if (isset($account)) 

    <div style="min-height: 70vh;" class="d-flex">

        @include('components.sidebar', ['active' => 'account'])

        <div style="width:80%;" class="px-6">
            <p class="px-4 h4 mb-4 fw-bold">
                <a href="{{ route('account') }}" class="text-decoration-none"><i class="fa-solid fa-chevron-left"></i></a>
                SỬA THÔNG TIN
            </p>

            <!-- Thông tin tài khoản -->
            <div class="w-75 ps-4 py-4 mb-4">
                <form action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="float-end position-relative rounded-6  rounded-circle overflow-hidden" style="width:130px;height:130px;">
                        @if ($account->image != null)
                        <img src="{{ asset('img/'.$account->image->image_url) }}" 
                            id="avatar-img"
                            class="w-100 h-100 rounded-circle object-fit-cover"
                        >
                        @else
                        <img src="{{ $account->image_link }}" 
                            id="avatar-img"
                            class="w-100 h-100 rounded-circle object-fit-cover"
                        >
                        @endif
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

                    <div class="p-2 d-flex text-white fw-bold fs-6 w-100 justify-content-around">
                        <a href="{{ route('account') }}" style="width:40%;" class="p-2 rounded-4 text-center text-decoration-none bg-black">HỦY</a>
                        <button type="submit" style="width:40%;" class="text-white fw-bold fs-6  rounded-4 bg-success">LƯU</a>
                    </div>
                </form>
            </div>
                
        </div>
    </div>


@endif
@endsection

@push('script')
<script type="text/javascript" src="{{ asset ('js/index.js') }}"></script>

@endpush