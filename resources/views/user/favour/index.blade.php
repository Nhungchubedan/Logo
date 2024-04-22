@extends('layouts.user')
@section('title', 'Sản phẩm yêu thích')
@section('link', 'Sản phẩm yêu thích')
@section('content')
    <div style="min-height: 70vh;" class="d-flex" >
        @include('components.sidebar', ['active' => 'favour'])
        <div style="width:80%;" class="px-6 form-parent">
            <p class="px-4 h4 mb-4 fw-bold">SẢN PHẨM YÊU THÍCH <span class="text-gray-600 fs-sm fw-light">({{ $favour->count() }} sản phẩm)</span></p>
            <div class="w-100 d-flex justify-content-end align-items-center mb-2">
                <div class="me-2 d-flex align-items-center">
                    <input type="checkbox" class="" id="check-all">
                    <label for="check-all" class="ms-1">Chọn tất cả</label>
                </div>
                <form class="" id="cart-form" method="post" action="{{ route('cart') }}">
                    @csrf
                    <button class="text-white bg-success px-4 py-2 ms-2 text-decoration-none fw-bold fs-sm rounded-5" 
                    name="add_cart" type="submit" value="1">
                        <i class="fa-solid fa-basket-shopping fs-sm"></i>&ensp;THÊM VÀO GIỎ
                    </button>
                </form>
            </div>
            <div class="d-flex flex-wrap mb-8">
                @if (isset($favour))
                    @foreach ($favour as $item)

                    <div style="height:340px;width:calc(25% - 16px)" class="bg-white pb-6 overflow-hidden rounded-3 shadow item m-2 position-relative" role="button">
                        <input type="checkbox" class="position-absolute check right-0 top-0 mt-2 me-2" name="id[]" form="cart-form" value="{{ $item->product->id_product }}">
                        <img 
                            src="{{ asset('img/'. $item->product->details->image->image_url ) }}" 
                            alt="" 
                            style="aspect-ratio: 1 / 1;"
                            class="object-fit-cover w-100"
                        >
                        <div class="px-4 py-3">
                            <p class="text-gray-600 fs-xs fw-bold text-uppercase m-0">
                                <a href="{{ route('product.list', ['brand-name' => $item->product->brand->idbrand] ) }}">{{ $item->product->brand->brand_name }}</a>
                            </p>
                            <div 
                                style="text-overflow: ellipsis;
                                display: -webkit-box;
                                -webkit-box-orient: vertical;
                                -webkit-line-clamp: 2;
                                line-height: 14px;      
                                max-height: 28px;"     
                                class="fs-sm fw-bold text-capitalize my-1 overflow-hidden">
                                <a href="{{ route('product.detail', ['id' => $item->product->id_product ] ) }}">{{ $item->product->product_name }}</a>
                            </div>
                            <ul class="m-0 p-0 d-flex list-unstyled align-items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($item->product->ratingvalue / $i >= 1)
                                    <li class="text-warning"><i class="fa-solid fa-star fs-sm"></i></li>
                                    @elseif ($item->product->ratingvalue - $i >= 0.5) 
                                    <li class="text-warning"><i class="fa-solid fa-star-half-stroke fs-sm"></i></li>
                                    @else
                                    <li class="text-warning"><i class="fa-regular fa-star fs-sm"></i></li>
                                    @endif
                                @endfor
                                <li class="ms-1 mt-1 fs-sm text-warning fw-bold">{{ $item->product->ratingvalue }}</li>
                                
                                <form action="{{ route('favour.destroy', $item->id_favour) }}" method="post" class="text-end flex-fill">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="bg-transparent">
                                        <i class="fa-solid fa-heart text-danger fs-6"></i>
                                    </button>
                                </form>

                            </ul>
                            <div class="d-flex align-items-center">
                                <p class="me-2 text-danger fw-bold fs-6">{{ number_format($item->product->newprice, 0, '', ',') }}</p>
                                <p class="me-2 text-grey text-decoration-line-through fs-xs text-gray-600">{{ number_format($item->product->unit_price, 0, '', ',') }}</p>
                                <p style="font-size:10px;" class="bg-danger text-white fw-bold rounded-2 m-0 px-1">-{{ $item->product->discount }}%</p>
                            </div>
                        </div>
                    </div>
                        
                    @endforeach
                @else 
                    <p class="text-gray-600 fs-6 m-10">Chưa có sản phẩm yêu thích.</p>
                    <a href="{{ route('welcome') }}" class="p-2 ms-2 fs-sm text-white fw-bold rounded-3 text-decoration-none bg-warning">KHÁM PHÁ</a>
                @endif
            </div> 
        </div>
    </div>    
@endsection
@push('script')
<script type="text/javascript" src="{{ asset ('js/favour.js') }}"></script>

@endpush