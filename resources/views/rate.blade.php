@if (isset($order))
<div style="background-color:rgba(0,0,0,0.3);" 
    class="box hidden top-0 start-0 end-0 bottom-0 position-fixed z-10"
>
    <form 
        method="post" action="{{ route('order.rate') }}" 
        style="width:fit-content;height:fit-content;" 
        class="position-relative overflow-y-auto bg-white m-auto rounded-4 py-2 px-4 mt-10"
        enctype="multipart/form-data"
    >
        @csrf
        <div role="button" class="quit position-absolute top-0 end-0 mt-2 me-2">
            <i class="fa-solid fa-circle-xmark text-danger h3"></i>
        </div>

        <p class="text-black h6 p-4 fw-bold border-bottom">ĐÁNH GIÁ ĐƠN HÀNG</p>

        <i role="button" style="left: 0;" class="hidden left-arrow fa-solid fa-chevron-left ms-1 position-absolute top-50 h1"></i>
        <i role="button" class="right-arrow fa-solid fa-chevron-right position-absolute top-50 h1 me-1 right-0"></i>

        <div style="width:480px;height:480px;" class="overflow-hidden">
            <div class="slide-list d-flex transition">
                @foreach ($item->orderdetail as $item)
                <div class="slide-item w-100 px-4 flex-shrink-0">
                    <input type="hidden" name="id[]" value="{{ $item->id_orderdetail }}">
                    <div class="d-flex shadow">
                        <img 
                            src="{{ asset('img/'. $item->product->details->image->image_url ) }}" 
                            alt=""
                            style="aspect-ratio: 1 / 1;"
                            class="object-fit-cover w-25"
                        >
                        <div class="flex-fill p-2">
                            <p class="fs-sm text-black fw-bold">{{ $item->product->product_name }}</p>
                            <p class="fs-sm text-gray-600 fw-light">{{ $item->product->brand->brand_name }}</p>
                        </div>
                    </div>
                    <div class="w-100 mt-4 d-flex justify-content-center">
                        <ul class="rate-list d-flex justify-content-center list-unstyled ">
                            <li class="rate-item">
                                <i class="hidden fill fa-solid fa-star fs-3 text-warning"></i>
                                <i class="unfill fa-regular fa-star fs-3 text-warning"></i>
                            </li>
                            <li class="rate-item">
                                <i class="hidden fill fa-solid fa-star fs-3 text-warning"></i>
                                <i class="unfill fa-regular fa-star fs-3 text-warning"></i>
                            </li>
                            <li class="rate-item">
                                <i class="hidden fill fa-solid fa-star fs-3 text-warning"></i>
                                <i class="unfill fa-regular fa-star fs-3 text-warning"></i>
                            </li>
                            <li class="rate-item">
                                <i class="hidden fill fa-solid fa-star fs-3 text-warning"></i>
                                <i class="unfill fa-regular fa-star fs-3 text-warning"></i>
                            </li>
                            <li class="rate-item">
                                <i class="hidden fill fa-solid fa-star fs-3 text-warning"></i>
                                <i class="unfill fa-regular fa-star fs-3 text-warning"></i>
                            </li>
                            <input type="hidden" name="rate[]" value="">
                        </ul>
                    </div>
                    @error('rate.'. $loop->index)
                    <p class="error text-danger fs-xs">
                        Sản phẩm chưa có đánh giá.
                    </p>
                    @enderror

                    <div class="w-100">
                        <label class="w-100 mb-1 fs-sm fw-bold text-black">Đánh giá</label>
                        <textarea name="review[]" rows="5" class="w-100 rounded-3 border border-1"></textarea>
                    </div>
                    @error('review.'. $loop->index)
                    <p class="error text-danger fs-xs">
                        Vui lòng đánh giá tối đa 500 ký tự.
                    </p>
                    @enderror

                    <div class="">
                        <p class="w-100 mb-1 fs-sm fw-bold text-black">Hình ảnh đính kèm (tối đa 3 hình)</p>
                        <div class="w-100 d-flex image-list">

                            <div class="image-container">
                                <div class="image-overlay hidden">
                                    <i role="button" class="fa-solid fa-xmark position-absolute top-0 end-0 fs-5 m-1"></i>
                                    <img src="" class="w-100 h-100 object-fit-cover">
                                </div>
                                <label for="image_1_{{ $item->id_orderdetail }}" >
                                    <i class="fa-solid fa-plus text-gray-600 fs-4"></i>
                                </label>
                                <input type="file" id="image_1_{{ $item->id_orderdetail }}" name="image_1[]" class="hidden">
                            </div>

                            <div class="image-container">
                                <div class="image-overlay hidden">
                                    <i class="fa-solid fa-xmark position-absolute top-0 end-0 fs-5 m-1"></i>
                                    <img src="" class="w-100 h-100 object-fit-cover">
                                </div>
                                <label for="image_2_{{ $item->id_orderdetail }}">
                                    <i class="fa-solid fa-plus text-gray-600 fs-5"></i>
                                </label>
                                <input type="file" id="image_2_{{ $item->id_orderdetail }}" name="image_2[]" class="hidden">
                            </div>

                            <div class="image-container">
                                <div class="image-overlay hidden">
                                    <i class="fa-solid fa-xmark position-absolute top-0 end-0 fs-5 m-1"></i>
                                    <img src="" class="w-100 h-100 object-fit-cover">
                                </div>
                                <label for="image_3_{{ $item->id_orderdetail }}">
                                    <i class="fa-solid fa-plus text-gray-600 fs-5"></i>
                                </label>
                                <input type="file" id="image_3_{{ $item->id_orderdetail }}" name="image_3[]" class="hidden">
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="d-block p-3 my-2 w-50 mx-auto bg-warning text-white fs-6 fw-bold text-center rounded-5">GỬI</a>
    
    </form>
</div>
@endif
