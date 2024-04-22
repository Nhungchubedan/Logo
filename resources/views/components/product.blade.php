@if (isset($product))
    @foreach ($product as $item)
    <div style="height:340px;width:calc(20% - 16px)" class="bg-white pb-6 overflow-hidden rounded-3 shadow-sm item m-2" role="button">
        <a href="{{ route('product.detail', ['id' => $item->id_product ] ) }}" class="text-decoration-none text-reset">
            <div class="w-100 overflow-hidden">
                <img 
                    src="{{ asset('img/'.$item->details->image->image_url) }}" 
                    alt="" 
                    style="aspect-ratio: 1 / 1;"
                    class="object-fit-cover w-100"
                >
            </div>
            <div class="px-4 py-3">
                <p class="text-gray-600 fs-xs fw-bold text-uppercase m-0">
                    <a href="{{ route('product.list', ['brand-name' => $item->brand->idbrand] ) }}">{{ $item->brand->brand_name }}</a>
                </p>
                <div 
                    style="text-overflow: ellipsis;
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 2;
                    line-height: 14px;      
                    max-height: 28px;"
                    class="fs-sm fw-bold text-capitalize my-1 overflow-hidden">
                    <a href="{{ route('product.detail', ['id' => $item->id_product ] ) }}">{{ $item->product_name }}</a>
                </div>
                <ul class="m-0 p-0 d-flex list-unstyled align-items-center">
                    @for ($i = 0; $i <= 4; $i++)
                        @if ($item->ratingvalue - $i >= 1)
                            <li class="text-warning"><i class="fa-solid fa-star fs-sm"></i></li>
                        @elseif ($item->ratingvalue - $i >= 0.5) 
                            <li class="text-warning"><i class="fa-solid fa-star-half-stroke fs-sm"></i></li>
                        @else
                            <li class="text-warning"><i class="fa-regular fa-star fs-sm"></i></li>
                        @endif
                    @endfor
                    <li class="ms-1 mt-1 fs-xs text-warning fw-bold">{{ $item->ratingvalue }}</li>
                </ul>
                <div class="d-flex align-items-center">
                    <p class="me-2 text-danger fw-bold fs-6">{{ number_format($item->newprice, 0, '', ',') }}</p>
                    <p class="me-2 text-grey text-decoration-line-through fs-xs text-gray-600">{{ number_format($item->unit_price, 0, '', ',') }}</p>
                    <p style="font-size:10px;" class="bg-danger text-white fw-bold rounded-2 m-0 px-1">-{{ $item->discount }}%</p>
                </div>
            </div>
        </a>
    </div>
        
    @endforeach

@endif