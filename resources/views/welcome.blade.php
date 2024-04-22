@extends('layouts.master')

@section('title', 'Trang chủ')
@section('content')
    <!-- SLIDE -->
    <ul style="height:475px;" class="list-unstyled position-relative slides">
        <li class=""><img src="https://www.guardian.com.vn/media/.renditions/wysiwyg/banner/Web_Slider_Banner_1410_x_440_2.png" class="w-100 position-absolute transition"></img></li>
        <li class=""><img src="https://www.guardian.com.vn/media/wysiwyg/SLIDE_BANNER_1410x440.jpg" class="w-100 position-absolute opacity-0 transition"></img></li>
        <li class=""><img src="https://www.guardian.com.vn/media/wysiwyg/Br2_Desktop_Mobile_web_1414x440px_2.jpg" class="w-100 position-absolute opacity-0 transition"></img></li>
        <li class=""><img src="https://www.guardian.com.vn/media/.renditions/wysiwyg/banner/Web_Slider_Banner.png" class="w-100 position-absolute opacity-0 transition"></img></li>
        <li class=""><img src="https://www.guardian.com.vn/media/.renditions/wysiwyg/banner/Web_Slider_Banner__CN.png" class="w-100 position-absolute opacity-0 transition"></img></li>
    </ul>
    <ul class="list-unstyled text-center dots">
        <li class="d-inline-block mx-1">
            <div style="height:10px; width:10px;" class="rounded-circle bg-secondary-subtle transition"></div>
        </li>
        <li class="d-inline-block mx-1">
            <div style="height:10px; width:10px;" class="rounded-circle bg-dark-subtle transition"></div>
        </li>
        <li class="d-inline-block mx-1">
            <div style="height:10px; width:10px;" class="rounded-circle bg-dark-subtle transition"></div>
        </li>
        <li class="d-inline-block mx-1">
            <div style="height:10px; width:10px;" class="rounded-circle bg-dark-subtle transition"></div>
        </li>
        <li class="d-inline-block mx-1">
            <div style="height:10px; width:10px;" class="rounded-circle bg-dark-subtle transition"></div>
        </li>
    </ul>
    <div class="w-100">

        <!-- LIST CATEGORY -->
        <div class="w-100 pb-8">
            <div style="width:85%;" class="m-auto position-relative">
                <p class="h4 fw-bold text-black my-6 ms-2">DANH MỤC</p>       
                @include('components.category', ['category' => $category])
            </div>
        </div>

        <!-- LIST PRODUCT -->
        <div class="w-100 pb-8 pt-4 bg-discovery-subtle">
            <div class="w-75 m-auto position-relative">
                <p class="h4 fw-bold text-black my-6 ms-2">ƯU ĐÃI KHỦNG <i class="fa-solid fa-dragon text-danger"></i></p>
                <img src="https://www.guardian.com.vn/media/.renditions/wysiwyg/landing-page/Milimili/SliderBanner_web.jpg" 
                class="banner"
                >
                <a href="{{ route('homepage', ['banner' => 'uu-dai-khung']) }}" class="fs-xs fw-bold position-absolute end-0 top-0 p-2 rounded-5 text-reset text-decoration-none see-all">
                    <span class="">XEM TẤT CẢ</span>
                    <i class="fa-solid fa-angle-right mx-1 "></i>
                </a>
                <div class="d-flex flex-wrap my-4"> 
                    @include('components.product', ['product' => $sale])
                </div>


            </div>
        </div>
        <div class="w-100 pb-8 pt-4">
            <div class="w-75 m-auto position-relative">
                <p class="h4 fw-bold text-black my-6 ms-2">THƯƠNG HIỆU ĐỘC QUYỀN</p>
                <img src="https://www.guardian.com.vn/media/.renditions/wysiwyg/banner/Web_Slider_Banner__EB.png" 
                class="banner"
                >
                <a href="{{ route('homepage', ['banner' => 'thuong-hieu-doc-quyen']) }}" class="fs-xs fw-bold position-absolute end-0 top-0 p-2 rounded-5 text-reset text-decoration-none see-all">
                    <span class="">XEM TẤT CẢ</span>
                    <i class="fa-solid fa-angle-right mx-1 "></i>
                </a>
                <div class="d-flex flex-wrap my-4"> 
                    @include('components.product', ['product' => $exclusive])
                </div>


            </div>
        </div>
        <div class="w-100 pb-8 pt-4 bg-discovery-subtle">
            <div class="w-75 m-auto position-relative">
                <p class="h4 fw-bold text-black my-6 ms-2">SẢN PHẨM BÁN CHẠY</p>
                <img src="https://www.guardian.com.vn/media/wysiwyg/banner/Head_PC_1.jpg" 
                class="banner"
                >
                <a href="{{ route('homepage', ['banner' => 'san-pham-ban-chay']) }}" class="fs-xs fw-bold position-absolute end-0 top-0 p-2 rounded-5 text-reset text-decoration-none see-all">
                    <span class="">XEM TẤT CẢ</span>
                    <i class="fa-solid fa-angle-right mx-1 "></i>
                </a>
                <div class="d-flex flex-wrap my-4"> 
                    @include('components.product', ['product' => $top])
                </div>


            </div>
        </div>

        <!-- LIST BRAND -->
        <div class="w-100 pb-8 pt-4">
            <div style="width:85%;" class="m-auto position-relative">
                <p class="h4 fw-bold text-black my-6 ms-2">THƯƠNG HIỆU NỔI BẬT</p>
                
                @include('components.brand', ['brand' => $brand])
                
            </div>
        </div>


    </div>

@endsection
