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
                <label>Mã danh mục</label>
                <input type="text" value="{{ $data->id_category }}" name="id_category" readonly/> 
            </div>
            @endif
            <div>
                <label>Tên danh mục</label>
                <input type="text" value="{{ $action === 'update' ? $data->category_name : '' }}" name="category_name">
                <span class="error hidden text-danger fs-xs">
                    @error('category_name')
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
            
        </div>
        <button type="submit" name="action" value="{{ $action }}" class="d-block p-3 text-decoration-none my-2 w-50 mx-auto bg-primary text-white fs-6 fw-bold text-center rounded-5">
            LƯU
        </button>
    </div>
</form>