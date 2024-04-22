@extends('layouts.master')
@section('title', 'Thương hiệu')
@section('content')

@if (isset($brand))

<div class="bg-white w-100 m-auto">
    <div style="width:80%;" class="m-auto">
        <p class="fs-xs pt-4 px-4 pb-8">
            <a href="{{route('welcome')}}" class="text-gray-600 ">TRANG CHỦ</a>
            <i class="fa-solid fa-chevron-right text-gray-600"></i>
            <span class="text-black">Thương hiệu nổi bật</span>
        </p>
        <img 
            src="https://www.guardian.com.vn/media/wysiwyg/banner/Head_PC_1.jpg" 
            class="w-100"
        >

        <div class="d-flex align-items-end justify-content-between">
            <p class="h4 fw-bold text-black mt-10">
                THƯƠNG HIỆU NỔI BẬT <span class="fw-light text-gray-600 fs-sm">({{ $count }} thương hiệu)</span>
            </p>

            <div style="width:220px;" class="d-flex align-items-center">
                <label for="sort" class="fs-sm text-black fw-bold me-1">Xếp theo:</label>
                <select name="sort" id="sort" class="flex-fill text-gray-600 fs-sm p-2 border rounded-3">
                    <option value="asc" class="text-black fs-sm fw-light p-2">Theo A -> Z</option>
                    <option value="desc" class="text-black fs-sm fw-light p-2">Theo Z -> A</option>
                </select>
            </div>
        </div>

        <!-- Search -->
        <form class="w-100 mb-10 position-relative">
            <input type="text" class="w-25 border rounded-4 py-2 px-8 fs-sm"
                placeholder="Tìm kiếm theo tên thương hiệu"
                name="q"
                onkeypress="if (event.keyCode === 13) { this.form.submit(); }"
            >
            <i class="position-absolute fa-solid fa-magnifying-glass position-absolute start-0 mt-3 mx-3"></i>
        </form>

        <!-- List Thương Hiệu -->
        <div class="w-100 d-flex flex-column">
            <div class="d-flex flex-wrap"> 

                @if ($count != 0)
                @foreach ($brand as $item)
                <div style="width:calc(20% - 16px);" class="mx-2 my-4 text-center">
                    <a href="{{ route('product.list', ['brand-name' => $item->idbrand] ) }}" class="text-decoration-none"><img 
                    src="{{ asset('img/'.$item->image->image_url) }}" 
                    alt="" 
                    style="height:100px;"
                    class="item w-100 shadow mb-2"></a>
                    <a href="{{ route('product.list', ['brand-name' => $item->idbrand] ) }}" class="text-decoration-none text-black fw-bold fs-5">{{ $item->brand_name }}</a>
                </div>

                @endforeach
                @else 
                <p class="fs-6 text-gray-600 mb-20">Không có thương hiệu phù hợp tìm kiếm.</p>
                @endif

            </div>

            <!-- Số Trang -->
            @if ($count != 0)
            <div class="py-4 d-flex justify-content-center mb-4">
                <div  class="page-number fs-6 d-flex align-items-center">
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

@endif

@endsection

@push('script')
<script type="text/javascript" src="{{ asset ('js/brand.js') }}"></script>
@endpush