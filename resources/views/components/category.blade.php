@if (isset($category))

<i style="left:-24px;" class="hidden fa-solid fa-chevron-left position-absolute fs-4 top-50 left-arrow" role="button"></i>
<div class="overflow-hidden">
    <div class="slide-list my-4 d-flex transition">        
        @foreach ($category as $item)
        <div style="width:10%;" class="slide-item px-2 text-center flex-shrink-0">
            <a href="{{ route('product.list', ['category-name' => $item->id_category] ) }}" class="text-decoration-none text-reset">
                <img 
                src="{{ asset('img/'. $item->image->image_url ) }}" 
                alt="" 
                style="aspect-ratio: 1 / 1;"
                class="item w-75 m-auto rounded-circle shadow">
            </a>
            <p class="fw-bold fs-sm my-2">{{ $item->category_name }}</p>
        </div>
        @endforeach
    </div>
</div>
<i style="right:-24px;" class="fa-solid fa-chevron-right position-absolute fs-4 top-50 right-arrow" role="button"></i>

@endif