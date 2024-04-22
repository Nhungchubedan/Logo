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
            <div>
                <label>Mã thương hiệu</label>
                @if ($action === 'update')
                <input type="text" value="{{ $data->id_brand }}" name="id_brand" readonly/> 
                @else
                <input type="text" value="" name="id_brand"/> 
                @endif
                <span class="error hidden text-danger fs-xs">
                    @error('id_brand')
                    {{ $message }}
                    @enderror
                </span>
            </div>

            <div>
                <label>Tên thương hiệu</label>
                <input type="text" value="{{ $action === 'update' ? $data->brand_name : '' }}" name="brand_name">
                <span class="error hidden text-danger fs-xs">
                    @error('brand_name')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Quốc gia</label>
                <input type="text" value="{{ $action === 'update' ? $data->nation : '' }}" name="nation">
                <span class="error hidden text-danger fs-xs">
                    @error('nation')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Website</label>
                <input type="text" value="{{ $action === 'update' ? $data->website_url : '' }}" name="website_url">
                <span class="error hidden text-danger fs-xs">
                    @error('website_url')
                    {{ $message }}
                    @enderror
                </span>
            </div>
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
                <label>Mô tả</label>
                <textarea name="description" rows="4">{{ $action === 'update' ? $data->description : '' }}</textarea>
                <span class="error hidden text-danger fs-xs">
                    @error('description')
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