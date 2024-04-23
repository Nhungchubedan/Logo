@if(auth()->check())
@include('components.cart')
<!-- Account -->
<div class="flex-fill d-flex justify-content-end align-items-center text-end position-relative">
    <div>
        <p class="fs-sm  me-2">Xin chào,</p>
        <p class="fs-sm fw-bold me-2">{{ Auth::user()->user_name }}</p>
    </div>
    @if (Auth::user()->image != null)
    <img 
        src="{{ asset('img/'. Auth::user()->image->image_url) }}" 
        alt="Avatar"
        role="button"
        style="width:50px;height:50px;"
        class="account-btn rounded-circle object-fit-cover border border-2 border-light"
    >
    @else
    <img 
        src="{{ Auth::user()->image_link }}" 
        alt="Avatar"
        role="button"
        style="width:50px;height:50px;"
        class="account-btn rounded-circle object-fit-cover border border-2 border-light"
    >
    @endif
    
    <!-- Hidden -->
    <ul style="width:200px;" 
        class="account-box text-gray-700 list-unstyled bg-white position-absolute transition rounded-3 shadow top-0 start-0 p-3 mt-10">
        <li class="d-flex align-items-center mb-2">
            @if (Auth::user()->image != null)
            <img src="{{ asset('img/'. Auth::user()->image->image_url) }}" 
                alt="Avatar"
                role="button"
                style="width:50px;height:50px"
                class="account-btn rounded-circle object-fit-cover mx-2"
            >
            @else
            <img src="{{ Auth::user()->image_link }}" 
                alt="Avatar"
                role="button"
                style="width:50px;height:50px"
                class="account-btn rounded-circle object-fit-cover mx-2"
            >
            @endif
            <div class="flex-fill text-start">
                <p class="fs-6 fw-bold text-black">{{ Auth::user()->user_name }}</p>
                <p class="fst-italic fs-xs">ID: {{ Auth::user()->id_user }}</p>
            </div>
        </li>
        <li class="w-100 py-2 px-4 fs-6 text-start">
            <a href="{{ route('order') }}" class="text-reset text-decoration-none">Quản lý đơn hàng</a>
        </li>
        <li class="w-100 py-2 px-4 fs-6 text-start">
            <a href="{{ route('favour') }}" class="text-reset text-decoration-none">Sản phẩm yêu thích</a>
        </li>
        <li class="w-100 py-2 px-4 fs-6 text-start">
            <a href="{{ route('account') }}" class="text-reset text-decoration-none">Cài đặt tài khoản</a>
        </li>
        <li class="w-100 py-2 px-4 fs-6 text-start">
            <a href="{{ route('cart') }}" class="text-reset text-decoration-none">Giỏ hàng của tôi</a>
        </li>
        <li class="w-100 py-2 px-4 fs-6 text-start">
            <a href="{{route('logout')}}" class="text-reset text-decoration-none">Đăng xuất</a>
        </li>
    </ul>

</div>
@endif