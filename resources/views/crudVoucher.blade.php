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
                <label>Mã giảm giá</label>
                @if ($action === 'update')
                <input type="text" value="{{ $data->id_voucher }}" name="id_voucher" readonly/> 
                @else
                <input type="text" value="" name="id_voucher"/> 
                @endif
                <span class="error hidden text-danger fs-xs">
                    @error('id_voucher')
                    {{ $message }}
                    @enderror
                    @error('isExisted')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div>
                <label>Tên mã</label>
                <input type="text" value="{{ $action === 'update' ? $data->voucher_name : '' }}" name="voucher_name">
                <span class="error hidden text-danger fs-xs">
                    @error('voucher_name')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="d-flex">
                <div class="w-50 pe-2">
                    <label>Giảm (%)</label>
                    <input type="number" name="voucher_value" min="0" max="50" value="{{ $action === 'update' ? $data->voucher_value : '' }}">
                    <span class="error hidden text-danger fs-xs">
                        @error('voucher_value')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="w-50 ps-2">
                    <label>Tối đa</label>
                    <input type="text" placeholder="{{ $action === 'update' ? $data->max : '' }}" value="{{ $action === 'update' ? $data->max : '' }}" name="max">
                    <span class="error hidden text-danger fs-xs">
                        @error('max')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
            <div class="d-flex">
                <div class="w-50 pe-2">
                    <label>Ngày bắt đầu</label>
                    <input type="date" value="{{ $action === 'update' ? $data->start_date : ''}}" name="start_date">
                    <span class="error hidden text-danger fs-xs">
                        @error('start_date')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
                <div class="w-50 ps-2">
                    <label>Ngày kết thúc</label>
                    <input type="date" value="{{ $action === 'update' ? $data->end_start : ''}}" name="end_date">
                    <span class="error hidden text-danger fs-xs">
                        @error('end_date')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
        </div>

        <button type="submit" name="action" value="{{ $action }}" class="d-block p-3 text-decoration-none my-2 w-50 mx-auto bg-primary text-white fs-6 fw-bold text-center rounded-5">
            LƯU
        </button>
    </div>
</form>