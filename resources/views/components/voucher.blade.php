<form method="post" style="background-color:rgba(0,0,0,0.3);display:none;" class="box top-0 start-0 end-0 bottom-0 position-fixed z-10">
    @csrf
    <div style="width:fit-content;height:fit-content;" class="position-relative bg-white m-auto rounded-4 py-2 px-4 mt-10">
        <div role="button" class="position-absolute top-0 end-0 mt-2 me-2">
            <i class="quit fa-solid fa-circle-xmark text-danger h3"></i>
        </div>
        <p class="text-black h6 p-4 fw-bold border-bottom">MÃ GIẢM GIÁ VÀ ƯU ĐÃI</p>
        <div style="width:480px;height:480px;" class="overflow-y-auto">
        @foreach ($voucher as $item)
            <div class="my-4 border border-black rounded-3 p-2 position-relative">
                <input type="radio" value="{{ $item->id_voucher }}" name="voucher" class="position-absolute top-0 end-0 mt-2 me-2">
                <div class="d-flex text-black align-items-center mb-4">
                    <i class="fa-solid fa-ticket fs-4"></i>&ensp;
                    <p class="fs-sm fw-bold text-capitalize pe-4">
                        {{ $item->idvoucher }} - voucher giảm {{ $item->voucher_value }}% {{ $item->maxvalue }} 
                        |
                        {{ $item->startdate }} - {{ $item->enddate }}
                    </p>
                </div>
                <p class="fw-bold fs-xs "><span class="fw-light text-gray-600">
                    Hạn sử dụng: </span>Đến 23:59 - {{ $item->end_date }} 
                </p>
            </div>
        @endforeach


        </div>
        <button 
            name="add-voucher"
            type="submit" 
            class="d-block p-3 text-decoration-none my-2 w-50 mx-auto bg-warning text-white fs-6 fw-bold text-center rounded-5"
        >
            ÁP DỤNG
        </button>
    </div>
</form>