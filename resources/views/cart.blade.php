<?php use App\Models\Cart; ?>
@php
    $cart = Cart::where('id_user', Auth::user()->id_user)->get();
@endphp
<div id="cart-btn" class="position-relative" role="button">
    <i class="fa-solid fa-basket-shopping h3 p-2 rounded-circle hover"></i>
    <span class="position-absolute end-0 top-0 px-1 bg-danger rounded-circle fs-xs">{{ $cart->count() }}</span>
    <div id="cart-box" style="width:300px;max-height:500px" class="position-absolute bg-white hidden mt-2 shadow rounded-3 overflow-y-auto top-50 end-0">
        <a href="{{ route('cart') }}" class="float-end text-success fs-sm mx-2 mt-4">Xem tất cả</a>
        <p class="fs-sm fw-bold p-4 text-black">GIỎ HÀNG</p>
        <ul class="list-unstyled m-0">
            @if (!$cart->isEmpty())
                @foreach ($cart as $item)
                    <li class="cart-item w-100 p-2">
                        <a href="{{ route('product.detail', ['id' => $item->product->id_product]) }}" class="text-decoration-none d-flex flex-nowrap align-items-center">
                            <img 
                                src="{{ asset('img/'. $item->product->details->image->image_url) }}" 
                                alt="aspect-ratio: 1 / 1;"
                                class="object-fit-cover w-25"
                            >
                            <div class="flex-fill p-2">
                                <div
                                    class="text-capitalize overflow-hidden text-black fw-bold fs-xs"
                                    style="text-overflow: ellipsis;
                                    display: -webkit-box;
                                    -webkit-box-orient: vertical;
                                    -webkit-line-clamp: 2;
                                    line-height: 12px;      
                                    max-height: 24px;"  
                                ><p>{{ $item->product->product_name }}</p></div>
                                <p class="fs-sm text-danger fw-bold">30,000</p>
                            </div>
                            <p class="text-danger flex-shrink-0 fw-bold fs-xs">x {{ $item->quantity }}</p>
                        </a>
                    </li>
                @endforeach
            @else 
                <li class="w-100 text-center mt-2 mb-6"><i class="fa-solid fs-3 text-gray-600 fa-cart-plus"></i></li>
            @endif
        </ul>
    
    </div>
</div>
