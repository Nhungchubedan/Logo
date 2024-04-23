<div style="background-color:rgba(0,0,0,0.3);" class="box top-0 start-0 end-0 bottom-0 position-fixed z-10">
    <div style="width:fit-content;height:fit-content;" class="position-relative bg-white m-auto rounded-4 py-2 px-4 mt-10">
        <div role="button" class="quit position-absolute top-0 end-0 mt-2 me-2">
            <i class="fa-solid fa-circle-xmark text-danger h3"></i>
        </div>
        <p class="text-black h6 p-4 fw-bold text-start border-bottom">
            CHI TIẾT ĐÁNH GIÁ #{{$data->id_rating}} - ĐƠN HÀNG #{{$data->orderdetail->order->id_order}}
        </p>
        
        <div style="width:600px;max-height:600px;" class="overflow-y-auto px-2">
            <p class="fs-sm my-2 text-success fw-bold text-start">Sản Phẩm Đánh Giá</p>
            <div class="d-flex">
                <img 
                    src="{{ asset('img/'. $data->orderdetail->product->details->image->image_url ) }}" 
                    style="aspect-ratio: 1 / 1;"
                    class="object-fit-cover w-25"
                >
                <div class="flex-fill p-2 text-start">
                    <p class="fs-sm text-black fw-bold">{{ $data->orderdetail->product->product_name }}</p>
                    <p class="fs-sm text-gray-600 fw-light">{{ $data->orderdetail->product->brand->brand_name }}</p>
                </div>
            </div>
            <p class="fs-sm my-2 text-success fw-bold text-start">Hình Ảnh Đánh Giá</p>
            <div class="d-flex">
                @if (isset($data->image1))
                <div class="w-25 me-3">
                    <img 
                        src="{{asset('img/'.$data->image1->image_url) }}" 
                        alt="" 
                        style="aspect-ratio:1 / 1;"
                        class=" w-100 object-fit-cover"
                    >
                </div>
                @endif
                @if (isset($data->image2))
                <div class="w-25 me-3">
                    <img 
                        src="{{asset('img/'.$data->image2->image_url) }}" 
                        alt="" 
                        style="aspect-ratio:1 / 1;"
                        class=" w-100 object-fit-cover"
                    >
                </div>
                @endif
                @if (isset($data->image3))
                <div class="w-25 me-3">
                    <img 
                        src="{{asset('img/'.$data->image3->image_url) }}" 
                        alt="" 
                        style="aspect-ratio:1 / 1;"
                        class=" w-100 object-fit-cover"
                    >
                </div>
                @endif
                @if (is_null($data->id_image1) && is_null($data->id_image1) && is_null($data->id_image1))
                <p class="py-2">Không có hình ảnh đánh giá</p>
                @endif
            </div>
            <p class="fs-sm my-2 text-success fw-bold text-start">Đánh Giá Của Khách Hàng</p>
            <textarea rows="5" class="text-start w-100 my-2" readonly>{{ $data->review }}</textarea>
        </div>
    </div>
</div>