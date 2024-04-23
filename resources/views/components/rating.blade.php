@foreach ($rating as $item)
    <div class="w-100 py-2">
        <div class="d-flex justify-content-between">
            <div class="d-flex">
                <img 
                    src="{{ asset('img/'. $item->user->image->image_url) }}" 
                    alt="Avatar" 
                    class="account-btn rounded-circle object-fit-cover shadow me-2"
                    style="width:50px;height:50px;"
                >
                <div class="">
                    <p class="fs-6 text-black fw-bold">{{ $item->user->user_name }}</p>
                    <ul class="m-0 p-0 d-flex list-unstyled align-items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($item->rating / $i >= 1)
                            <li class="text-warning"><i class="fa-solid fa-star fs-xs"></i></li>
                        @else
                            <li class="text-warning"><i class="fa-regular fa-star fs-xs"></i></li>
                        @endif
                    @endfor
                    </ul>
                </div>
            </div>
            <p class="text-gray-600 fs-sm text-end">{{ $item->created_at }}</p>
        </div>
        <div class="w-100 ps-16 pe-4">
            <div class="fs-6 text-black py-2">{{ $item->review }}</div>
            <div class="d-flex">
                @if (isset($item->image1))
                <div class="w-25 me-2">
                    <img 
                        src="{{asset('img/'.$item->image1->image_url) }}" 
                        alt="" 
                        style="aspect-ratio:1 / 1;"
                        class=" w-100 object-fit-cover"
                    >
                </div>
                @endif
                @if (isset($item->image2))
                <div class="w-25 me-2">
                    <img 
                        src="{{asset('img/'.$item->image2->image_url) }}" 
                        alt="" 
                        style="aspect-ratio:1 / 1;"
                        class=" w-100 object-fit-cover"
                    >
                </div>
                @endif
                @if (isset($item->image3))
                <div class="w-25 me-2">
                    <img 
                        src="{{asset('img/'.$item->image3->image_url) }}" 
                        alt="" 
                        style="aspect-ratio:1 / 1;"
                        class=" w-100 object-fit-cover"
                    >
                </div>
                @endif
            </div>
        </div>
    </div>
    @if (isset($item->reply))
    <div class="w-75 p-4 my-2 rounded-3 shadow-md ms-auto bg-success-subtle">
        <p class="text-success fs-6 fw-bold">
            <span class="text-white p-1 me-1 bg-success rounded-3">LOGO</span>
            Quản trị viên
        </p>
        <div class="fs-6 text-black mt-4">{!! $item->reply->reply !!}</div>
    </div>
    @endif
@endforeach