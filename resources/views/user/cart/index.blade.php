@extends('layouts.user')
@section('title', 'Giỏ hàng')
@section('link', 'Giỏ hàng')
@section('content')
                        
    <div style="min-height: 70vh;" class="d-flex" >
        @include('components.sidebar', ['active' => 'cart'])
        <div style="width:80%;" class="px-6">
            <p class="px-4 h4 mb-2 fw-bold">GIỎ HÀNG <span class="text-gray-600 fs-sm fw-light">({{ $cart->count() }} sản phẩm)</span></p>
            <div class="ms-4 d-flex align-items-center">
                <input type="checkbox" id="check-all">
                <label for="check-all" class="ms-1">Chọn tất cả</label>
            </div>
            <div class="d-flex">
                <div style="width:60%;max-height:600px;" class="overflow-y-auto d-flex p-4 mt-2 mb-8 flex-wrap bg-light">
                @if (isset($cart))
                    @foreach($cart as $item)
                    <div style="height:160px;" class="w-100 cart-product position-relative bg-white p-2 mb-4 shadow d-flex align-items-center justify-content-between">
                        <input 
                            type="checkbox" 
                            class="check position-absolute top-0 start-0 mt-2 ms-2" 
                            name="id-cart[]" 
                            value="{{ $item->id_cart }}"
                            form="order"
                        >
                        <img 
                            src="{{ asset('img/'.$item->product->details->image->image_url) }}" 
                            alt="aspect-ratio: 1 / 1;"
                            class="object-fit-cover h-100"
                        >
                        <div  class="ps-2 flex-1 h-100 pe-14">
                            <p 
                                class="text-capitalize text-black fw-bold py-2 fs-sm overflow-hidden"
                                style="text-overflow: ellipsis;
                                display: -webkit-box;
                                -webkit-box-orient: vertical;  
                                -webkit-line-clamp: 2;
                                line-height: 14px;      
                                max-height: 36px;"  
                            >
                                <a href="{{ route('product.detail', ['id' => $item->product->id_product ] ) }}">{{ $item->product->product_name }}</a>
                            </p>
                            <p class="fs-sm text-danger fw-bold py-2">{{ number_format($item->product->newprice, 0, '', ',') }} đ</p>
                            <input type="hidden" class="price" value="{{ $item->product->newprice }}" />

                            <form class="rounded-5 d-flex px-2 py-1 align-items-center float-start justify-content-between bg-discovery-subtle" method="post">
                                <button class="bg-transparent" type="submit" name="action" value="minus">
                                    <i role="button" class="fa-solid fa-minus text-gray-600 fs-xs"></i>
                                </button>
                                <input type="text" 
                                    style="width:40px;"
                                    class="quantity bg-transparent text-center text-black fs-xs fw-bold " 
                                    value="{{ $cart[$loop->index]->quantity }}" readonly 
                                />
                                <input type="hidden" name="id" value="{{ $item->id_cart }}">
                                <button class="bg-transparent" type="submit" name="action" value="plus">
                                    <i role="button" class="fa-solid fa-plus text-gray-600 fs-xs"></i>
                                </button>
                                @csrf
                            </form>
                        </div>
                        <div class="position-relative h-100">
                            <form action="{{ route('cart.destroy', $item->id_cart ) }}" method="post" class="position-absolute top-0 end-0">
                                @csrf
                                @method('delete')
                                    <button type="submit" class="bg-transparent text-danger float-end">
                                        Xóa
                                    </button>
                            </form>
                            <div class="position-absolute bottom-0 end-0 text-end">
                                <p class="text-gray-600 fs-sm " style="white-space: nowrap;">Tạm tính:</p>     
                                @php
                                    $price = $item->product->newprice;
                                    $quantity = $cart[$loop->index]->quantity;
                                    $total = $price * $quantity;
                                @endphp
                                <p class="text-end text-danger fw-bold">{{ number_format($total, 0, '', ',') }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
        
                @else 
                    <p class="text-gray-600 fs-6 m-10">Chưa có sản phẩm nào trong giỏ của bạn.</p>
                    <a href="{{ route('welcome') }}" 
                    style="height:fit-content;"
                    class="p-2 ms-2 mt-0 fs-sm text-white fw-bold rounded-3 text-decoration-none bg-warning">KHÁM PHÁ</a>
                @endif
                </div> 
                <div style="width:40%;" class="p-2 ps-4">
                    <div class="pt-4 mb-6 border border-1 rounded-4">
                        <p class="h5 fw-bold ps-4 w-100 pb-4 border-bottom">Thông Tin Đơn Hàng</p>
                        <ul class="pt-2 m-0 px-0 fw-bold">
                            <li class="mb-4 px-4 d-flex justify-content-between">
                                <span class="fs-6 text-gray-700">Tổng sản phẩm</span>
                                <input type="text" name="total-quantity" class="w-50 fs-6 bg-transparent text-black fw-bold text-end" 
                                value="0" readonly/>
                            </li>
                            <li class="py-4 px-4 d-flex justify-content-between">
                                <span class="fs-6 text-gray-700">Tạm tính</span>
                                <input type="text" name="total-payment" class="w-50 fs-5 bg-transparent text-danger fw-bold text-end" 
                                value="0 đ" readonly/>
                            </li>
                        </ul>
                    </div>
                    <p class="fst-italic mt-2 px-2 fs-sm">Vui lòng kiểm tra kĩ địa chỉ giao hàng trước khi đặt.</p>
                    <form action="{{ route('order.order') }}" id="order" method="post" target="_blank">
                        @csrf
                        <button 
                            type="button" name="add-order" target="_blank"
                            class="unactive mt-2 text-center w-100 fs-6 py-3 fw-bold text-white text-decoration-none bg-warning d-block rounded-5">
                            MUA HÀNG
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('script')
<script type="text/javascript" src="{{ asset ('js/cart.js') }}"></script>
@endpush