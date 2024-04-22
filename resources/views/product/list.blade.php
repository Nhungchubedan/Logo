@extends('layouts.master')
@section('title', 'Danh Sách Sản Phẩm')
@section('content')

@if (isset($product))

<div class="bg-white w-100 m-auto">
    <div style="width:80%;" class="m-auto">
        <p class="fs-xs pt-4 pb-8 px-4">
            <a href="{{route('welcome')}}" class="text-gray-600 ">TRANG CHỦ</a>
            <i class="fa-solid fa-chevron-right text-gray-600"></i>
            <span class="text-black">{{ $title }}</span>
        </p>
        <img 
            src="https://www.guardian.com.vn/media/wysiwyg/banner/Head_PC_1.jpg" 
            class="w-100"
        >
        <div class="d-flex align-items-end justify-content-between">
            <p class="h4 fw-bold text-black mt-10">
                <span class="text-uppercase">{{ $title }}</span> 
                <span class="fw-light text-gray-600 fs-sm">( {{ $count }} sản phẩm)</span>
            </p>

            <div style="width:220px;" class="d-flex align-items-center">
                <label for="sort" class="fs-sm text-black fw-bold me-1">Xếp theo:</label>
                <select name="sort" id="sort" class="flex-fill text-gray-600 fs-sm p-2 border rounded-3">
                    <option value="default" class="text-black fs-sm fw-light p-2">Mặc định</option>
                    <option value="create-at" class="text-black fs-sm fw-light p-2">Mới nhất</option>
                    <option value="best-sell" class="text-black fs-sm fw-light p-2">Bán chạy nhất</option>
                    <option value="desc" class="text-black fs-sm fw-light p-2">Giá giảm dần</option>
                    <option value="asc" class="text-black fs-sm fw-light p-2">Giá tăng dần</option>
                </select>
            </div>
        </div>
        <div class="w-100 d-flex">

            <!-- Bộ Lọc -->
            <form style="width:20%;" id="form-filter" class="fs-sm mt-2 d-flex flex-column align-items-center">
                <input type="hidden" id="route">
                <ul class="w-100 list-unstyled border border-1 rounded-3 bg-discovery-sublte">
                    <li id="filter" class=" fw-bold text-black p-3">LỌC THEO</li>
                    <li id="filter-price" class="fw-bold text-black p-3 border-top">
                        KHOẢNG GIÁ 
                        <div class="float-end">
                            <i role="button" class="open-filter fa-solid fa-plus"></i>
                            <i role="button" class="close-filter fa-solid fa-minus hidden"></i>
                        </div>
                        <ul class="w-100 px-4 py-2 hidden">
                            <div id="range" class="mt-4 w-75 mx-auto"></div>
                            <div class="mt-1 mb-4 w-100 d-flex justify-content-between">
                                <p id="minslide" class="fs-xs text-gray-600"><span>10,000</span> đ</p>
                                <p id="maxslide" class="fs-xs text-gray-600"><span>2,000,000</span> đ</p>
                            </div>
                            
                            <div class="d-flex justify-content-center align-items-center">
                                <input id="minprice" name="minprice" style="width:80px;" type="text" class="border p-2 rounded-3" value="10000">
                                <i class="fa-solid fa-minus text-black mx-1"></i>
                                <input id="maxprice" name="maxprice" style="width:80px;" type="text" class="border p-2 rounded-3" value="2000000">
                            </div>

                        </ul>
                    </li>
                    <li id="filter-discount" class="fw-bold text-black p-3 border-top">
                        KHUYẾN MÃI
                        <div class="float-end">
                            <i role="button" class="open-filter fa-solid fa-plus"></i>
                            <i role="button" class="close-filter fa-solid fa-minus hidden"></i>
                        </div>
                        <ul class="list-unstyled px-4 py-2 hidden">
                            <li class="text-gray-600 fw-light my-1 d-flex align-items-center">
                                <input type="radio" name="discount" value="1" class="me-2">    
                                <span>0 - 10%</span>
                            </li>
                            <li class="text-gray-600 fw-light my-1 d-flex align-items-center">
                                <input type="radio" name="discount" value="2" class="me-2">    
                                <span>0 - 20%</span>
                            </li>
                            <li class="text-gray-600 fw-light my-1 d-flex align-items-center">
                                <input type="radio" name="discount" value="3" class="me-2">    
                                <span>0 - 30%</span>
                            </li>
                            <li class="text-gray-600 fw-light my-1 d-flex align-items-center">
                                <input type="radio" name="discount" value="4" class="me-2">    
                                <span>0 - 40%</span>
                            </li>
                            <li class="text-gray-600 fw-light my-1 d-flex align-items-center">
                                <input type="radio" name="discount" value="5" class="me-2">    
                                <span>0 - 50%</span>
                            </li>
                        </ul>
                    </li>
                    <li id="filter-brand" class="fw-bold text-black p-3 border-top">
                        THƯƠNG HIỆU
                        <div class="float-end">
                            <i role="button" class="open-filter fa-solid fa-plus"></i>
                            <i role="button" class="close-filter fa-solid fa-minus hidden"></i>
                        </div>
                        <ul style="max-height:200px;" class="hidden list-unstyled px-4 py-2 overflow-y-auto">
                            @foreach ($brand as $item)
                            <li class="text-uppercase text-gray-600 fw-light my-1 d-flex align-items-center">
                                <input type="checkbox" class="me-2" name="brand[]" value="{{ $item->id_brand }}">
                                <span>{{ $item->brand_name }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <button type="submit" class="bg-black p-2 mb-10 w-75 rounded-5 text-white fw-bold" type="submit">ÁP DỤNG</button>
            </form>


            <div style="width:80%" class="ps-6 d-flex flex-column justify-content-between">

                <!-- List Sản Phẩm -->
                <div class="d-flex flex-wrap"> 
                @if (count($product) != 0)
                    @foreach ($product as $item)
                    <div style="height:340px;width:calc(25% - 16px)" class="bg-white pb-6 overflow-hidden rounded-3 shadow-sm item m-2" role="button">
                    <a href="{{ route('product.detail', ['id' => $item->id_product ] ) }}" class="text-decoration-none">
                        <img 
                            src="{{ asset('img/'. $item->details->image->image_url ) }}" 
                            alt="" 
                            style="aspect-ratio: 1 / 1;"
                            class="object-fit-cover w-100"
                        >
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
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($item->ratingvalue / $i >= 1)
                                        <li class="text-warning"><i class="fa-solid fa-star fs-sm"></i></li>
                                    @elseif ($item->ratingvalue - $i >= 0.5) 
                                        <li class="text-warning"><i class="fa-solid fa-star-half-stroke fs-sm"></i></li>
                                    @else
                                        <li class="text-warning"><i class="fa-regular fa-star fs-sm"></i></li>
                                    @endif
                                @endfor
                                <li class="ms-1 mt-1 fs-sm text-warning fw-bold">{{ $item->ratingvalue }}</li>
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
                @else
                <p class="text-gray-600 fs-6 m-10">Không có sản phẩm phù hợp yêu cầu.</p>
                @endif
                </div>


                <!-- Số Trang -->
                @if (count($product) != 0)
                <div class="py-4 d-flex justify-content-center mb-4">
                    <div class="page-number fs-6 d-flex align-items-center">
                        <a id="back-arrow" href="#" class="text-decoration-none me-2">
                            <p style="width:40px;height:40px;line-height:40px;" class="rounded-circle border border-success text-center">
                                <i class="fa-solid fa-chevron-left text-success"></i>
                            </p>
                        </a>
                        @php 
                            $page = ceil($count / 15);
                        @endphp
                        @for ($i = 1; $i <= $page; $i++)
                        <span role="button" data="{{ $i }}" class="text-decoration-none fw-bold mx-1 page {{ $active == $i ? 'active' : '' }}">
                            <p style="width:40px;height:40px;line-height:40px;" class="text-center rounded-circle">
                            {{ $i }}</p>
                        </span>
                        @endfor
                        <a id="next-arrow" href="#" class="text-decoration-none ms-2">
                            <p style="width:40px;height:40px;line-height:40px;" class="rounded-circle border border-success text-center">
                            <i class="fa-solid fa-chevron-right text-success"></i>
                            </p>
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
   </div>
    
</div>

@endif
@endsection

@push('script')
<script type="text/javascript" src="{{ asset ('js/product.js') }}"></script>
@endpush