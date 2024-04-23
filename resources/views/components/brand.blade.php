@if(isset($brand))
<a href="{{ route('brand') }}" class="fs-xs fw-bold position-absolute end-0 top-0 p-2 rounded-5 text-reset text-decoration-none see-all">
    <span class="">XEM TẤT CẢ</span>
    <i class="fa-solid fa-angle-right mx-1 "></i>
</a>

<div class="d-flex flex-wrap my-4">
    @foreach ($brand as $item)
    <div style="width:calc(16.667% - 16px);" class="mx-2 my-4 text-center">
        <a href="{{ route('product.list', ['brand-name' => $item->idbrand] ) }}" class="text-decoration-none">
        <img 
        src="{{ asset('img/'.$item->image->image_url) }}" 
        alt="" 
        style="height:70px;"
        class="item w-100 shadow">
        </a>
    </div>
    @endforeach
</div>
@endif
