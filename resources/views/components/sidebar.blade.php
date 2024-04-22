<div style="width:20%;" class="pe-2">
    <ul id="sidebar" class="list-unstyled border rounded-3 fw-bold text-gray-600 border-1 bg-discovery-sublte">
        <li class="py-4 px-3 border-bottom {{$active == 'account' ? 'active' : ''}}">
            <a href="{{ route('account') }}" class="text-decoration-none">
                <i class="fa-solid fa-gear"></i>&ensp;
                Cài đặt tài khoản 
                <i class="fa-solid fa-chevron-right text-white float-end mt-1"></i>
            </a>
        </li>
        <li class="py-4 px-3 border-bottom {{$active == 'order' ? 'active' : ''}}">
            <a href="{{ route('order') }}" class="text-decoration-none">
                <i class="fa-regular fa-note-sticky"></i>&ensp;
                Quản lý đơn hàng 
                <i class="fa-solid fa-chevron-right text-white float-end mt-1"></i>
            </a>
        </li>
        <li class="py-4 px-3 border-bottom {{$active == 'favour' ? 'active' : ''}}">
            <a href="{{ route('favour') }}" class="text-decoration-none">
                <i class="fa-solid fa-heart"></i>&ensp;
                Sản phẩm yêu thích 
                <i class="fa-solid fa-chevron-right text-white float-end mt-1"></i>
            </a>
        </li>
        <li class="py-4 px-3 border-bottom {{$active == 'cart' ? 'active' : ''}}">
            <a href="{{ route('cart') }}" class="text-decoration-none">
                <i class="fa-solid fa-basket-shopping"></i>&ensp;
                Giỏ hàng của tôi 
                <i class="fa-solid fa-chevron-right text-white float-end mt-1"></i>
            </a>
        </li>
        <li class="py-4 px-3">
            <a href="{{ route('logout') }}" class="text-decoration-none">
                <i class="fa-solid fa-right-from-bracket"></i></i>&ensp;
                Đăng xuất
                <i class="fa-solid fa-chevron-right text-white float-end mt-1"></i>
            </a>
        </li>
    </ul>
</div>