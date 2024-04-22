<div style="background-color:rgba(0,0,0,0.3);" class="box top-0 start-0 end-0 bottom-0 position-fixed z-10">
    <div style="width:fit-content;height:fit-content;" class="position-relative bg-white m-auto rounded-4 py-2 px-4 mt-10">
        <div role="button" class="quit position-absolute top-0 end-0 mt-2 me-2">
            <i class="fa-solid fa-circle-xmark text-danger h3"></i>
        </div>
        <p class="text-black h6 p-4 fw-bold text-start border-bottom">CHI TIẾT SẢN PHẨM #{{$data->id_product}}</p>
        
        <div style="width:600px;max-height:600px;" class="overflow-y-auto pb-4">
            <table class="w-100">
                <tr class="text-start">
                    <td class="fw-bold p-4">Hình ảnh:</td>
                    <td>
                        <img 
                        src="{{ asset('img/'.$data->details->image->image_url) }}" 
                        style="width:100px;aspect-ratio: 1 / 1;"
                        class="object-fit-cover">
                    </td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold p-4">Giới thiệu sản phẩm:</td>
                    <td>{!! $data->details->introduction !!}</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold p-4">Công dụng:</td>
                    <td>{!! $data->details->uses !!}</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold p-4">Thành phần:</td>
                    <td>{!! $data->details->incredient !!}</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold p-4">Dành cho đối tượng:</td>
                    <td>{!! $data->details->for !!}</td>
                </tr>
                <tr class="text-start ">
                    <td class="fw-bold p-4">Hạn sử dụng:</td>
                    <td>{{ $data->details->exp }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>