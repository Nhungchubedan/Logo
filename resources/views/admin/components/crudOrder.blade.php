<form method="post" style="background-color:rgba(0,0,0,0.3);"  enctype="multipart/form-data" 
    class="box top-0 start-0 end-0 bottom-0 position-fixed z-10"
>
    @csrf
    <div style="width:fit-content;height:fit-content;" class="position-relative bg-white m-auto rounded-4 py-2 px-4 mt-10">
        <div role="button" class="quit position-absolute top-0 end-0 mt-2 me-2">
            <i class="fa-solid fa-circle-xmark text-danger h3"></i>
        </div>
        <p class="text-black h6 p-4 fw-bold text-start border-bottom">
            XÁC NHẬN ĐƠN HÀNG
        </p>
        
        <div class="crud">
            <input type="hidden" name="form-post" value="">
            <input type="hidden" name="form-get" value="{{ old('form-post') ?? '' }}">
            <input type="hidden" name="id_order" value="{{ $order->id_order }}">
            <div>
                <label>Lựa chọn</label>
                <select name="confirm" class="confirm">
                    <option value="1">Xác nhận đơn hàng</option>
                    <option value="0">Từ chối đơn hàng</option>
                </select>
                <span class="error hidden text-danger fs-xs">
                    @error('confirm')
                    {{ $message }}
                    @enderror
                </span>
            </div>
            <div class="reason hidden">
                <label>Lý do hủy đơn</label>
                <select name="reason" class="mb-4">
                    <option value="1">Sản phẩm hết hàng</option>
                    <option value="2">Địa chỉ giao hàng không đủ thông tin</option>
                    <option value="3">Giao hàng không thể thực hiện</option>
                    <option value="4">Không thể liên lạc được với khách hàng</option>
                    <option value="5">Khác</option>
                </select>
                <div class="reason-other hidden">
                    <textarea class="summernote mt-4 " name="reason_other" rows="5"></textarea>
                    <span class="error hidden text-danger fs-xs">
                        @error('reason_other')
                        {{ $message }}
                        @enderror
                    </span>
                </div>
            </div>
        </div>

        <button type="submit" class="d-block p-3 text-decoration-none my-2 w-50 mx-auto bg-primary text-white fs-6 fw-bold text-center rounded-5">
            LƯU
        </button>
    </div>
</form>