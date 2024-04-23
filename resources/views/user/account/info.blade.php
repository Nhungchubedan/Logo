@extends('layouts.user')
@section('title', 'Cài đặt tài khoản')
@section('link', 'Cài đặt tài khoản')
@section('content')

    <div style="min-height: 70vh;" class="d-flex">

        @include('components.sidebar', ['active' => 'account'])

        <div style="width:80%;" class="px-6">
            <p class="px-4 h4 mb-4 fw-bold">
                <a href="{{ route('account') }}" class="text-decoration-none"><i class="fa-solid fa-chevron-left"></i></a>
                ĐỊA CHỈ GIAO HÀNG
            </p>
            <div class="w-75 ps-4 py-4 mb-4">
                <form action="" class="" method="post">
                    @csrf
                    <div class="mb-6">
                        <label class="w-100 fs-6 fw-bold text-black">
                            Tên đầy đủ <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="p-3 rounded-3 mt-1 w-100 border border-1" name="fullname"
                        value="{{ $info ? $info->full_name : '' }}" required/>
                        <span class="error text-danger fs-xs">
                        @error('fullname')
                            {{ $message }}
                        @enderror
                        </span>
                    </div>

                    <div class="mb-6">
                        <label class="w-100 fs-6 fw-bold text-black">
                            Số điện thoại<span class="text-danger"> *</span><br>
                        </label>
                        <input type="text" class="p-3 rounded-3 mt-1 w-100 border border-1" name="phone" 
                        value="{{ $info ? $info->phone : '' }}" required/>
                        <span class="error text-danger fs-xs">
                        @error('phone')
                            {{ $message }}
                        @enderror
                        </span>
                    </div>
                    <div class="mb-6">
                        <label class="w-100 fs-6 fw-bold mb-2 text-black">
                            Loại địa chỉ<span class="text-danger"> *</span><br>
                        </label>
                        
                        <input type="radio" class="border border-1 rounded-3 pe-4" id="company" name="type" value="1"
                            <?php echo (($info ? $info->type : '') === 1) ? 'checked' : ''; ?>
                        >
                        <label class="fs-6 text-black fw-light" for="company">Công ty</label>
                        
                        <input type="radio" class="ms-4 border border-1 rounded-3" id="house" name="type" value="0" 
                            <?php echo (($info ? $info->type : '') === 0) ? 'checked' : ''; ?>
                        >
                        <label class="fs-6 text-black fw-light" for="house">Nhà riêng</label>
                    </div>
                    <div class="mb-6 w-100 d-flex">
                        <div class="pe-2 flex-1">
                            <label class="w-100 fs-6 fw-bold text-black">
                                Tỉnh/Thành Phố<span class="text-danger"> *</span><br>
                            </label>
                            <select name="province" id="province" class="p-3 rounded-3 mt-1 w-100 border border-1" required>
                                <option disabled selected>Chọn Tỉnh/Thành phố</option>
                                @if ($address)
                                    @foreach ($address['province'] as $item)
                                    <option value="{{ $item->code }}" 
                                        <?php echo ($info->province == $item->name ? 'selected' : '') ?>
                                    >
                                    {{ $item->name_with_type }}
                                    </option>
                                    @endforeach
                                @else
                                    @foreach ($province as $item)
                                    <option value="{{ $item->code }}" >
                                    {{ $item->name_with_type }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="px-2 flex-1">
                            <label class="w-100 fs-6 fw-bold text-black">
                                Quận/Huyện<span class="text-danger"> *</span><br>
                            </label>
                            <select name="district" id="district" class="p-3 rounded-3 mt-1 w-100 border border-1" required>
                                <option disabled selected>Chọn Quận/Huyện</option>
                                @if ($address)
                                    @foreach ($address['district'] as $item)
                                    <option value="{{ $item->code }}" 
                                        <?php echo ($info->district == $item->name_with_type ? 'selected' : '') ?>
                                    >
                                    {{ $item->name_with_type }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="ps-2 flex-1">
                            <label class="w-100 fs-6 fw-bold text-black">
                                Phường/Xã<span class="text-danger"> *</span><br>
                            </label>
                            <select name="commune" id="commune" class="p-3 rounded-3 mt-1 w-100 border border-1" required>
                                <option disabled selected>Chọn Phường/Xã</option>
                                @if ($address)
                                    @foreach ($address['commune'] as $item)
                                    <option value="{{ $item->code }}" 
                                        <?php echo ($info->commune == $item->name_with_type ? 'selected' : '') ?>
                                    >
                                    {{ $item->name_with_type }}
                                    </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="w-100 fs-6 fw-bold text-black">
                            Địa chỉ chi tiết<span class="text-danger"> *</span><br>
                        </label>
                        <input type="text" class="p-3 rounded-3 mt-1 w-100 border border-1" name="address" 
                        value="{{ $info ? $info->detail_address : '' }}" required/>
                        <span class="error text-danger fs-xs">
                        @error('address')
                            {{ $message }}
                        @enderror
                        </span>
                    </div>

                    <div class="p-2 d-flex text-white fw-bold fs-6 w-100 justify-content-around">
                        <a href="{{ route('account') }}" style="width:40%;" 
                        class="p-2 rounded-4 text-center text-decoration-none bg-black">HỦY</a>
                        <button type="submit" style="width:40%;" class="text-white fw-bold fs-6  rounded-4 bg-success">LƯU</a>
                    </div>
                </form>
            </div>
                
        </div>
    </div>

@endsection

@push('script')
<script type="text/javascript" src="{{ asset ('js/dropdown.js') }}"></script>
@endpush