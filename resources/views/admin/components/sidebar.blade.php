@php
$data = [
    [
        'id'        => 'order',
        'icon'      => 'fa-solid fa-boxes-stacked',
        'name'      => 'Quản lý đơn hàng',
        'route'     => 'admin.order.index',
    ],
    [
        'id'        => 'product',
        'icon'      => 'fa-brands fa-product-hunt',
        'name'      => 'Quản lý sản phẩm',
        'route'     => 'admin.product.index',
    ],
    [
        'id'        => 'voucher',
        'icon'      => 'fa-solid fa-paper-plane',
        'name'      => 'Quản lý mã giảm',
        'route'     => 'admin.voucher.index',
    ],
    [
        'id'        => 'payment',
        'icon'      => 'fa-brands fa-paypal',
        'name'      => 'Quản lý thanh toán',
        'route'     => 'admin.payment.index',
    ],
    [
        'id'        => 'brand',
        'icon'      => 'fa-solid fa-copyright',
        'name'      => 'Quản lý thương hiệu',
        'route'     => 'admin.brand.index',
    ],
    [
        'id'        => 'category',
        'icon'      => 'fa-solid fa-list',
        'name'      => 'Quản lý danh mục',
        'route'     => 'admin.category.index',
    ],
    [
        'id'        => 'account',
        'icon'      => 'fa-solid fa-users',
        'name'      => 'Quản lý tài khoản',
        'route'     => 'admin.account.index',
    ],
    [
        'id'        => 'rating',
        'icon'      => 'fa-solid fa-ranking-star',
        'name'      => 'Quản lý đánh giá',
        'route'     => 'admin.rating.index',
    ],
    [
        'id'        => 'report',
        'icon'      => 'fa-solid fa-chart-column',
        'name'      => 'Thống kê & Báo cáo',
        'route'     => 'admin.report.index',
    ],


    
]

@endphp

<div style="width:240px;top:70px;" class="flex-shrink-0 position-fixed bottom-0 start-0">
    <ul id="sidebarAdmin" class="text-capitalize text-white h-100 fw-bold bg-black fs-sm py-4 list-unstyled">    
        <li class="py-4 px-6 fs-6 border-bottom">
            <a href="{{ url(route('admin.home', ['prefix' => 'admin'])) }}" class="text-decoration-none">
                TRANG CHỦ
                <i class="fa-solid fa-chevron-right text-black float-end mt-1"></i>
            </a>
        </li>
        @foreach ($data as $item)
        @if (check_user_access($item['id']))
        <li class="py-4 px-6 border-bottom">
            <a href="{{ route( $item['route'] ) }}" class="text-white text-reset text-decoration-none">
                <i class=" {{ $item['icon'] }} "></i>&ensp;
                {{ $item['name'] }}
                <i class="fa-solid fa-chevron-right text-black float-end mt-1"></i>
            </a>
        </li>
        @endif
        @endforeach
    </ul>
</div>