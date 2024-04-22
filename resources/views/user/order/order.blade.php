@extends('layouts.order')
@section('title','Đặt hàng')
@section('content')
@include('components.voucher', ['voucher' => $voucher])
<div style="width:80%;" class="mx-auto">
<div class="d-flex order-page py-10">
    <div style="width:70%;" class="p-2">
        <p class="h4 mb-1 fw-bold text-black">Thông Tin Giao Hàng</p>
        <p class="fs-sm fw-light fst-italic mb-2 text-gray-700">Phí giao 20K (nội thành HCM), phí giao 30K (ngoại tỉnh). MIỄN PHÍ GIAO HÀNG đơn từ 99K. Dự kiến giao hàng từ 2-5 ngày, trừ Chủ Nhật, Lễ Tết.</p>
        <div action="" class="border border-1 p-6 text-gray-700 fs-6 fw-bold rounded-4">
            <div class="mb-6">
                <label class="mb-2 text-black">Họ tên người nhận</label><span class="text-danger"> *</span><br>
                <input readonly type="text" form="buy" value="{{$info->full_name}}" class="fs-6 w-100 border border-1 rounded-3 py-2 px-4" name="fullname">
            </div>
            <div class="mb-6 d-flex">
                <div class="w-50 pe-2">
                    <label class="mb-2 text-black">Số điện thoại</label><span class="text-danger"> *</span><br>
                    <input readonly type="text" form="buy" value="{{$info->phone}}" class="w-100 border border-1 rounded-3 py-2 px-4" name="phone">
                </div>
                <div class="w-50 ps-2">
                    <label class="mb-2 text-black">Email</label><span class="text-danger"> *</span><br>
                    <input readonly value="{{$info->user->email}}" class="w-100 border border-1 rounded-3 py-2 px-4" name="email" readonly>
                </div>
            </div>
            <div class="mb-6">
                <label class="mb-2 text-black">Loại địa chỉ</label><span class="text-danger"> *</span><br>
                
                <input disabled type="radio"  class="border border-1 rounded-3 py-2 px-4" form="buy" id="company" name="type" value="1"
                    <?php echo $info->type === 1 ? 'checked' : ''; ?>
                >
                <label class="mb-2 text-black fw-light" for="company">Công ty</label>
                
                <input disabled type="radio" class="ms-4 border border-1 rounded-3 py-2 px-4" form="buy" id="house" name="type" value="0"
                    <?php echo $info->type === 0 ? 'checked' : ''; ?>
                >
                <label class="mb-2 text-black fw-light" for="house">Nhà riêng</label>
            </div>
            <div class="mb-6 w-100 d-flex">
                <div class="pe-2 flex-1">
                    <label class="w-100 fs-6 fw-bold text-black">
                        Tỉnh/Thành Phố<span class="text-danger"> *</span><br>
                    </label>
                    <select name="province" form="buy" id="province" class="p-3 rounded-3 mt-1 w-100 border border-1" readonly>
                        <option value="{{ $info->province }}" >
                        {{ $info->province }}
                        </option>
                    </select>
                </div>
                <div class="px-2 flex-1">
                    <label class="w-100 fs-6 fw-bold text-black">
                        Quận/Huyện<span class="text-danger"> *</span><br>
                    </label>
                    <select name="district" form="buy" id="district" class="p-3 rounded-3 mt-1 w-100 border border-1" readonly>
                        <option value="{{ $info->district }}" selected>
                        {{ $info->district }}
                        </option>
                    </select>
                </div>
                <div class="ps-2 flex-1">
                    <label class="w-100 fs-6 fw-bold text-black">
                        Phường/Xã<span class="text-danger"> *</span><br>
                    </label>
                    <select name="commune" form="buy" id="commune" class="p-3 rounded-3 mt-1 w-100 border border-1" readonly>
                        <option value="{{ $info->commune }}" selected>
                        {{ $info->commune }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="mb-6">
                <label class="mb-2 text-black">Địa chỉ chi tiết</label><span class="text-danger"> *</span><br>
                <input readonly type="text" form="buy" value="{{$info->detail_address}}" class="w-100 border border-1 rounded-3 py-2 px-4" name="address">
            </div>
            <div class="mb-2">
                <label class="mb-2 text-black">Ghi chú đơn hàng</label><br>
                <textarea type="text" form="buy" rows="4" class="w-100 border border-1 rounded-3 py-2 px-4" name="note"></textarea>
            </div>
        </div>

        <p class="h4 mb-4 mt-6 fw-bold text-black">Phương Thức Thanh Toán <span class="text-danger">*</span></p>
        <div class="">
            <div class="paymethod w-50 d-flex rounded-3 mb-4 p-6 border border-1">
                <input type="radio" form="buy" name="paymethod" value="off" class="mt-1" required>
                <label class="ps-2 fs-6 text-black">Thanh toán khi nhận hàng</label>
            </div>
            <div class="paymethod w-50 d-flex rounded-3 mb-4 p-6 border border-1">
                <input type="radio" form="buy" name="paymethod" value="onl" class="mt-1" required>
                <label class="ps-2 fs-6 text-black">Thanh toán quét mã QR - VNPAY</label>
            </div>
        </div>
    </div>
    <div style="width:30%;" class="p-2">
        <div class="mb-4 border border-1 rounded-4 overflow-hidden">
            <p class="h5 fw-bold ps-4 w-100 p-4 border-bottom text-black bg-light">ĐƠN HÀNG</p>
            <ul class="pt-2 m-0 px-0 fw-bold">
                <li class="mb-4 px-4 d-flex justify-content-between">
                    <span class="fs-sm text-gray-700">Tổng sản phẩm</span>
                    <span class="fs-sm text-black fw-bold">{{ $totalQuantity }}</span>
                </li>
                <li class="mb-4 px-4 d-flex justify-content-between">
                    <span class="fs-sm text-gray-700">Tạm tính</span>
                    <span class="fs-sm text-black fw-bold">{{ number_format($totalPayment, 0, '', ',') }} đ</span>
                </li>
                <li id="discount-order" class="mb-4 px-4 d-flex justify-content-between">
                    <span class="fs-sm text-gray-700">Giảm giá</span>
                    <span  class="fs-sm text-black fw-bold">- {{ number_format($discountCost, 0, '', ',') }} đ</span>
                    @if (isset($idVoucher))
                    <input type="hidden" name="voucher" form="buy" value="{{ $idVoucher }}">
                    @endif
                </li>
                <li class="mb-4 px-4 d-flex justify-content-between">
                    <span class="fs-sm text-gray-700">Phí vận chuyển</span>
                    <span class="fs-sm text-black fw-bold">+ {{ number_format($shippingFee, 0, '', ',') }} đ</span>
                    <input type="hidden" form="buy" name="shipping" value="{{ $shippingFee }}">
                </li>
                <li class="py-4 px-4 border-top d-flex border-top justify-content-between">
                    <span class="fs-6 text-gray-700">Tổng thanh toán</span>
                    <span class="fs-5 text-danger">{{ number_format($total, 0, '', ',') }} đ</span>
                    <input type="hidden" form="buy" name="total" value="{{ $total }}">
                </li>
            </ul>
        </div>
        <div role="button" class="btn rounded-4 border border-1 d-flex py-2 px-4 align-items-center justify-content-between">
            <span class="fw-bold h5 text-black m-0">Ưu Đãi Giảm Giá</span>
            <i class="fa-solid fa-angle-right fw-bold h5 text-black mt-1"></i>
        </div>
        <div class=" border border-1 rounded-4 d-flex my-4 flex-wrap">
            <p class="h5 fw-bold m-0 ps-4 w-100 p-4 border-bottom text-black bg-light">GIỎ HÀNG</p>

            <div style="max-height:500px;" class="overflow-y-auto w-100 px-2">
                @foreach ($orderdetail as $item)
                <input type="hidden" name="orderdetail[]" form="buy" value="{{ $item }}">
                <div class="w-100 p-2 d-flex border-bottom align-items-center">
                    <img 
                        src="{{ asset('img/'. $item->product->details->image->image_url) }}" 
                        alt=""
                        class="ratio-1x1 w-25"
                    >
                    <div class="flex-fill px-2">
                        <div 
                            class="text-capitalize text-black fw-bold fs-xs overflow-hidden"
                            style="text-overflow: ellipsis;
                            display: -webkit-box;
                            -webkit-box-orient: vertical;
                            -webkit-line-clamp: 2;
                            line-height: 12px;      
                            max-height: 24px;"  
                        >{{ $item->product->product_name }}</div>
                        <p class="fs-sm text-danger fw-bold">{{ number_format($item->product->newprice, 0, '', ',') }} đ</p>
                    </div>
                    <p class="text-danger flex-shrink-0 fw-bold fs-xs">x {{ $item->quantity }}</p>
                </div>
                @endforeach
            </div>

        </div> 
        <form action="{{ route('order.pay') }}" method="post" id="buy">
            @csrf
            <button type="submit" class="d-block fs-sm text-center fw-bold bg-success text-white w-100 py-3 rounded-5 text-decoration-none">
                ĐẶT HÀNG
            </button>
        </form>
    </div>
</div>
</div>
@endsection 
@push('script')
<script type="text/javascript" src="{{ asset ('js/dropdown.js') }}"></script>
@endpush