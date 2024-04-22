<form method="post" style="background-color:rgba(0,0,0,0.3);"  enctype="multipart/form-data" 
    class="box top-0 start-0 end-0 bottom-0 position-fixed z-10"
>
    @csrf
    <div style="width:fit-content;height:fit-content;" class="position-relative bg-white m-auto rounded-4 py-2 px-4 mt-10">
        <div role="button" class="quit position-absolute top-0 end-0 mt-2 me-2">
            <i class="fa-solid fa-circle-xmark text-danger h3"></i>
        </div>
        <p class="text-black h6 p-4 fw-bold text-start border-bottom">
            {{ $action === 'update' ? 'CHỈNH SỬA' : 'THÊM MỚI'}}
        </p>
        
        <div class="crud">
            <input type="hidden" name="form-post" value="">
            <input type="hidden" name="form-get" value="{{ old('form-post') ?? '' }}">
            @if ($action === 'update')
            <div>
                <label>Mã sản phẩm</label>
                <input type="text" value="{{ $data->id_product }}" name="id_product" readonly/> 
            </div>
            @endif
            <div>
                <label>Tên sản phẩm</label>
                <input type="text" value="{{ $action === 'update' ? $data->product_name : '' }}" name="product_name">
                <span class="error hidden text-danger fs-xs">
                    @error('product_name')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Đơn giá</label>
                <input type="text" value="{{ $action === 'update' ? $data->unit_price : '' }}" name="unit_price">
                <span class="error hidden text-danger fs-xs">
                    @error('unit_price')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="d-flex">
                <div class="w-50 pe-2">
                    <label>Thương hiệu</label>
                    <select name="id_brand">
                        @foreach ($brand as $row)
                            @if ($action === 'update')
                            <option value="{{ $row->id_brand }}" 
                                <?php echo ($row->id_brand == $data->id_brand) ? 'selected': ''?>
                            >{{ $row->brand_name }}</option>
                            @else
                            <option value="{{ $row->id_brand }}">{{ $row->brand_name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span class="error hidden text-danger fs-xs">
                        @error('id_brand')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="w-50 ps-2">
                    <label>Danh mục</label>
                    <select name="id_category">
                        @foreach ($category as $row)
                            @if ($action === 'update')
                            <option value="{{ $row->id_category }}" 
                                <?php echo ($row->id_category == $data->id_category) ? 'selected': ''?>
                            >{{ $row->category_name }}</option>
                            @else
                            <option value="{{ $row->id_category }}">{{ $row->category_name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <span class="error hidden text-danger fs-xs">
                        @error('id_category')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="d-flex">
                <div class="w-25">
                    <label>Tồn kho</label>
                    <input type="number" name="iventory" min="1" max="1000" value="{{ $action === 'update' ? $data->iventory : '' }}">
                    <span class="error hidden text-danger fs-xs">
                        @error('iventory')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="w-25">
                    <label>Giảm giá (%)</label>
                    <input type="number" name="discount" min="0" max="50" value="{{ $action === 'update' ? $data->discount : '' }}">
                    <span class="error hidden text-danger fs-xs">
                        @error('discount')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <!-- Chi tiết sản phẩm -->
            <div>
                <label>Hình ảnh</label>
                <input type="file" accept="image/*" name="image">
                <span class="error hidden text-danger fs-xs">
                    @error('image')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Hạn sử dụng</label>
                <input type="text" value="{{ $action === 'update' ? $data->details->exp : '' }}" name="exp">
                <span class="error hidden text-danger fs-xs">
                    @error('exp')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Giới thiệu</label>
                <textarea class="summernote" name="introduction" rows="5">{{ $action === 'update' ? $data->details->introduction : '' }}</textarea>
                <span class="error hidden text-danger fs-xs">
                    @error('introduction')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Công dụng</label>
                <textarea class="summernote" name="uses" rows="5">{{ $action === 'update' ? $data->details->uses : '' }}</textarea>
                <span class="error hidden text-danger fs-xs">
                    @error('uses')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Thành phần</label>
                <textarea class="summernote" name="incredient" rows="5">{{ $action === 'update' ? $data->details->incredient : '' }}</textarea>
                <span class="error hidden text-danger fs-xs">
                    @error('incredient')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Dành cho</label>
                <textarea class="summernote" name="for" rows="5">{{ $action === 'update' ? $data->details->for : '' }}</textarea>
                <span class="error hidden text-danger fs-xs">
                    @error('for')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            
        </div>

        <button type="submit" name="action" value="{{ $action }}" class="d-block p-3 text-decoration-none my-2 w-50 mx-auto bg-primary text-white fs-6 fw-bold text-center rounded-5">
            LƯU
        </button>
    </div>
</form>