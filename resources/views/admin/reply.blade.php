<form method="post" style="background-color:rgba(0,0,0,0.3);" class="box top-0 start-0 end-0 bottom-0 position-fixed z-10">
    @csrf
    <div style="width:fit-content;height:fit-content;" class="position-relative bg-white m-auto rounded-4 py-2 px-4 mt-10">
        <div role="button" class="quit position-absolute top-0 end-0 mt-2 me-2">
            <i class="fa-solid fa-circle-xmark text-danger h3"></i>
        </div>
        <p class="text-black h6 p-4 fw-bold text-start">PHẢN HỒI ĐÁNH GIÁ #{{$data->id_rating}}</p>
        
        <div style="width:600px;max-height:600px;" class="overflow-y-auto pb-4">
            <input type="hidden" name="form-post" value="">
            <input type="hidden" name="form-get" value="{{ old('form-post') ?? '' }}">
            <input type="hidden" name="id_rating" value="{{$data->id_rating}}">

            @if (isset($data->reply))
            <textarea class="summernote" name="reply" rows="5">{{ $data->reply->reply }}</textarea>
            <span class="error hidden text-danger fs-xs">
                @error('reply')
                {{ $message }}
                @enderror
            </span>
            @else
            <textarea class="summernote" name="reply" rows="5"></textarea>
            <span class="error hidden text-danger fs-xs">
                @error('reply')
                {{ $message }}
                @enderror
            </span>
            @endif
        </div>
        @if (isset($data->reply))
        <button type="submit" name="action" value="update" 
            class="d-block p-3 text-decoration-none my-2 w-50 bg-primary mx-auto text-white fs-6 fw-bold text-center rounded-5"
        >
            CHỈNH SỬA
        </button>
        @else
        <button type="submit" name="action" value="add" 
            class="d-block p-3 text-decoration-none my-2 w-50 mx-auto bg-warning text-white fs-6 fw-bold text-center rounded-5"
        >
            GỬI
        </button>
        @endif
    </div>
</form>