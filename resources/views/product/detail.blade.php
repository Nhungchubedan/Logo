@extends('layouts.master')

@section('title', $product->product_name )

@section('content')
<div class="w-75 bg-white m-auto">
    <p class="fs-xs py-2 px-4">
        <a href="{{route('welcome')}}" class="text-gray-600 ">TRANG CHỦ</a>
        <i class="fa-solid fa-chevron-right text-gray-600"></i>
        <span class="text-black">{{ $product->product_name }}</span>
    </p>

    <div class="d-flex pt-10">
        <div class="p-16 w-50">
            <img 
                src="{{ asset('img/'.$product->details->image->image_url) }}" 
                alt="" 
                class="w-100 rounded-3 ratio-1x1 shadow-md"
            >
        </div>
        <div class="w-50 pe-6">
            <p class="text-capitalize fs-4 fw-bold">{{ $product->product_name }}</p>
            <div>
                <p class="ms-1 mt-1 fs-sm float-end text-black fw-bold">
                    <span>{{ $rating->count() }}</span> đánh giá
                </p>
                <ul class="m-0 p-0 d-flex list-unstyled align-items-center">
                    @for ($i = 0; $i <= 4; $i++)
                        @if ($product->ratingvalue - $i >= 1)
                            <li class="text-warning"><i class="fa-solid fa-star fs-sm"></i></li>
                        @elseif ($product->ratingvalue - $i >= 0.5) 
                            <li class="text-warning"><i class="fa-solid fa-star-half-stroke fs-sm"></i></li>
                        @else
                            <li class="text-warning"><i class="fa-regular fa-star fs-sm"></i></li>
                        @endif
                    @endfor
                    <li class="ms-1 mt-1 fs-sm text-warning fw-bold">{{ $product->ratingvalue }}</li>
                </ul>
            </div>
            <p class="fs-sm fw-bold text-gray-600 my-1">
                Đã bán: <span class="text-black fw-light fs-6">{{ $product->orderdetail->sum('quantity') }}</span>
            </p>
            <p class="fs-sm fw-bold text-gray-600 my-1">
                Thương hiệu: <span class="text-black fw-light fs-6">{{ $product->brand->brand_name }}</span>
            </p>
            <p class="fs-sm fw-bold text-gray-600 my-1">
                SKU: <span class="text-black fw-light fs-6">{{ $product->id_product }}</span>
            </p>
            <div class="d-flex align-items-center my-4 justify-content-between">

                <div class="d-flex align-items-center">
                    <p class="me-2 text-danger fw-bold fs-3">{{ number_format($product->newprice, 0, '', ',') }}</p>
                    <p class="me-4 text-grey text-decoration-line-through fs-5 text-gray-600">{{ number_format($product->unit_price, 0, '', ',') }}</p>
                    <p class="bg-danger text-white p-1 fs-xs fw-bold rounded-3">-{{ $product->discount }}%</p>
                </div>

                <form action="{{ route('favour') }}" class="" method="post">
                    <input type="hidden" name="id" value="{{ $product->id_product }}">
                    <button class="bg-transparent" type="submit"><i class="fa-regular fa-heart fs-5 text-gray-600"></i></button>
                    @csrf
                </form>

            </div>
            <div class="d-flex align-items-center">
                <form action="{{ route('order.order') }}" class="w-75 d-flex align-items-center" method="post" target="_blank">

                    <div class="w-50">
                        <div class="quantity-box rounded-5 d-flex px-4 p-2 align-items-center justify-content-between bg-discovery-subtle">
                            <i role="button" class="minus fa-solid fa-minus text-gray-600 fs-6"></i>
                            <input type="text" 
                            style="width:40px;"
                            name="quantity"
                            class="quantity bg-transparent text-center text-black fs-6 fw-bold " 
                            value="1" readonly />
                            <i role="button" class="plus fa-solid fa-plus text-gray-600 fs-6"></i>
                        </div>
                    </div>

                    <input type="hidden" name="id-product" value="{{ $product->id_product }}">

                    <div class="w-50 p-1 h-100" role="button">
                        <button type="submit" name="add-order" class="rounded-5 text-center w-100 fs-6 bg-danger p-2 text-white fw-bold">
                            MUA NGAY
                        </button>
                    </div>
                    @csrf
                </form>
                <form action="" class="w-50" method="post">
                    
                    <input type="hidden" name="id" value="{{ $product->id_product }}">
                    <div class="w-100">
                        <button type="submit" class="rounded-5 text-center w-100 fs-6 bg-success p-2 text-white fw-bold">
                            <i class="fa-solid fa-basket-shopping mx-2"></i>
                            THÊM VÀO GIỎ
                        </button>
                    </div>
                    @csrf

                </form>
            </div>
            <div class="p-4 bg-warning-subtle rounded-3 my-8 border border-1 border-warning-subtle">
                <p class="fw-bold fs-5 mb-2 text-warning">Voucher Tiết Kiệm</p>
                <ul class="fs-6 ps-8">
                    @foreach ($voucher as $item)
                    <li class="">Voucher <span class="text-warning">{{ $item->idvoucher }}</span> - {{ $item->voucher_name }}</li>
                    @endforeach
                </ul>
            </div>
            
        </div>
    </div>
    <div class="">


        <!-- CHI TIẾT SẢN PHẨM -->
        <ul style="margin-bottom:300px;" class="option position-relative list-unstyled fw-bold fs-6 d-flex rounded-3 shadow">
            <li role="button" class="active w-25 rounded-3 p-4 transition text-center">GIỚI THIỆU</li>
                <div class="position-absolute fw-light top-100 px-10 pb-20 pt-6">
                    {!! $product->details->introduction !!} 
                </div>
            <li role="button" class="w-25 rounded-3 p-4 transition text-center">CÔNG DỤNG</li>
                <div class="position-absolute hidden fw-light top-100 px-10 pb-20 pt-6">
                    {!! $product->details->uses !!} 
                </div>
            <li role="button" class="w-25 rounded-3 p-4 transition text-center">THÀNH PHẦN</li>
                <div class="position-absolute hidden fw-light top-100 px-10 pb-20 pt-6">
                    {!! $product->details->incredient !!} 
                </div>
            <li role="button" class="w-25 rounded-3 p-4 transition text-center">THÔNG TIN</li>
                <div class="position-absolute hidden fw-light top-100 px-10 pb-20 pt-6">
                    <span class="fw-bold">Dành cho: </span>{{ $product->details->for}}<br>
                    <span class="fw-bold">Hạc sử dụng: </span>{{ $product->details->exp}}
                </div>
        </ul>


        <!-- ĐÁNH GIÁ -->
        <div class="w-75 m-auto pb-6">
            <div class="d-flex align-items-center">
                <p class="fs-4 fw-bold text-black">ĐÁNH GIÁ CỦA KHÁCH HÀNG</p>
                <ul class="m-0 p-0 d-flex list-unstyled align-items-center">
                    <li class="ms-1 text-gray-600 fs-sm me-3">({{ $rating->count() }} Đánh giá)</li>
                    @for ($i = 0; $i <= 4; $i++)
                        @if ($product->ratingvalue - $i >= 1)
                            <li class="text-warning"><i class="fa-solid fa-star fs-sm"></i></li>
                        @elseif ($product->ratingvalue - $i >= 0.5) 
                            <li class="text-warning"><i class="fa-solid fa-star-half-stroke fs-sm"></i></li>
                        @else
                            <li class="text-warning"><i class="fa-regular fa-star fs-sm"></i></li>
                        @endif
                    @endfor
                    <li class="ms-1 mt-1 fs-6 text-warning fw-bold">{{ $product->ratingvalue }}</li>
                </ul>
            </div>
            <div class="">
                @include('components.rating', ['rating' => $rating])
            </div>
        </div>
    </div>
</div>

<div class="w-100 pb-8 pt-4 bg-discovery-subtle">
    <div class="w-75 m-auto position-relative">
        <p class="h4 fw-bold text-black mt-6 ms-2">SẢN PHẨM LIÊN QUAN</p>
        <div class="d-flex flex-wrap"> 
            @include('components.product', ['product' => $related])
        </div>
    </div>
</div>
@endsection
