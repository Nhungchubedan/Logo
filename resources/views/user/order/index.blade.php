@extends('layouts.user')
@section('title', 'Quản lý đơn hàng')
@section('link', 'Quản lý đơn hàng')
@section('content')

<div style="min-height: 70vh;" class="d-flex">
    @include('components.sidebar', ['active' => 'order'])
    <div style="width:80%;" class="px-6">
        <p class="px-4 h4 fw-bold">QUẢN LÝ ĐƠN HÀNG</p>
        
        <div class="w-100 d-flex ms-4 my-2 order-status">
            <p role="button" style="width:100px;" data="all"  
                class="sort active p-2 text-center fs-sm fw-bold border border-dark border-2 me-2 rounded-3">
                Tất cả
            </p>
            <p role="button" style="width:100px;" data="done" 
                class="sort p-2 text-center fs-sm fw-bold border border-dark border-2 me-2 rounded-3">
                Đã giao
            </p>
            <p role="button" style="width:100px;" data="cancel" 
                class="sort p-2 text-center fs-sm fw-bold border border-dark border-2 me-2 rounded-3">
                Đã hủy
            </p>
        </div>
        <div class="p-4">
            <ul class="list-unstyled">
                    @if (isset($order) && $order->count() != 0)
                        @foreach ($order as $item)
                        <li class="border border-1 rounded-3 overflow-hidden mb-4">
                            <div class="fs-sm text-gray-600 d-flex justify-content-between bg-light p-2 align-items-center">
                                <div class="">
                                    <p class="">
                                        Mã đơn hàng: {{ $item->id_order}} | 
                                        Đặt lúc: {{ $item->order_time }} | 
                                        Thanh toán: {{ $item->payment->payment_method }} |
                                        Trạng thái: {{ $item->order_status }}
                                    </p>
                                    <p class="">Tổng tiền: <span class="text-success fw-bold">{{ number_format($item->total, 0, '', ',') }} đ</span></p>
                                </div>
                                <a href="{{ route('order.detail', ['id' => $item->id_order]) }}" class="text-danger fw-bold">Xem chi tiết <i class="fa-solid fa-caret-right"></i></a>
                            </div>
                            <div style="max-height:300px;" class="overflow-y-auto p-4 d-flex flex-wrap align-items-center">
                                @foreach ($item->orderdetail as $detail)
                                <div class="w-50 p-2 d-flex align-items-center justify-content-between">
                                    <img 
                                        src="{{ asset('img/'.$detail->product->details->image->image_url) }}" 
                                        alt=""
                                        style="aspect-ratio: 1 / 1;"
                                        class="object-fit-cover w-25"
                                    >
                                    <div class="px-2 flex-fill">
                                        <div 
                                            style="text-overflow: ellipsis;
                                            display: -webkit-box;
                                            -webkit-box-orient: vertical;
                                            -webkit-line-clamp: 2;
                                            line-height: 14px;      
                                            max-height: 28px;"
                                            class="fs-sm fw-bold text-capitalize my-1 overflow-hidden">
                                            <a href="{{ route('product.detail', ['id' => $detail->product->id_product ] ) }}">{{ $detail->product->product_name }}</a>
                                        </div>
                                        <p class="fs-sm text-danger fw-bold">{{ number_format($detail->product->newprice, 0, '', ',') }}</p>
                                    </div>
                                    <p class="text-danger flex-shrink-0 fw-bold fs-xs">x {{ $detail->quantity }}</p>
                                </div>
                                @endforeach
                            </div>
                            <div class="w-100 mb-4 me-4 d-flex justify-content-end">
                            @switch ($item->order_status)
                                @case ('Đã giao hàng')
                                <form action="{{ route('order.order') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id-order" value="{{ $item->id_order }}">
                                    <button 
                                        style="width:140px;"
                                        target="_blank"
                                        name="add-order"
                                        class="me-2 d-block text-center text-white fw-bold fs-sm p-2 rounded-3 bg-success text-decoration-none">
                                        MUA LẠI
                                    </button>
                                </form>
                                @if (isset($item->orderdetail[0]->rating))
                                    <p 
                                        style="width:140px;"
                                        class="me-2 d-block text-center text-gray-600 fw-bold fs-sm p-2 rounded-3 bg-light">
                                        ĐÃ ĐÁNH GIÁ
                                    </p>
                                    @break
                                @else
                                    <a 
                                        style="width:140px;"
                                        href="#" 
                                        class="btn me-2 d-block text-center text-white fw-bold fs-sm p-2 rounded-3 bg-warning text-decoration-none">
                                        ĐÁNH GIÁ
                                    </a>
                                    @include('components.rate', ['order' => $item])
                                @endif
                                @break
                            @case ('Đã hủy')
                                <form action="{{ route('order.order') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id-order" value="{{ $item->id_order }}">
                                    <button 
                                        style="width:140px;"
                                        target="_blank"
                                        name="add-order"
                                        class="me-2 d-block text-center text-white fw-bold fs-sm p-2 rounded-3 bg-success text-decoration-none">
                                        MUA LẠI
                                    </button>
                                </form>
                                @break
                            @case('Đang giao hàng')
                                <form method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $item->id_order }}">
                                    <button 
                                        style="width:140px;"
                                        target="_blank"
                                        name="recieve-order"
                                        class="me-2 d-block text-center text-white fw-bold fs-sm p-2 rounded-3 bg-success text-decoration-none">
                                        NHẬN HÀNG
                                    </button>
                                </form>
                                @break
                            @case('Chờ xác nhận')
                                <div>
                                    <p 
                                    style="width:140px;"
                                    role="button"
                                    data="{{ $item->id_order }}"
                                    class="btn-confirm me-2 d-block text-center text-white fw-bold fs-sm p-2 rounded-3 bg-danger text-decoration-none">
                                    HỦY ĐƠN
                                    </p>
                                    @include('components.confirm', [
                                        'title'     => 'Xác nhận hủy đơn hàng',
                                        'content'   => 'Bạn có chắc chắn muốn hủy đơn hàng này?',
                                        'name'      => 'id',
                                        'value'     => $item->id_order,
                                    ])
                                </div>
                                @break
                            @endswitch
                            </div>
                        </li>
                        @endforeach
                    @else
                        <p class="text-gray-600 fs-6 m-10">Không có đơn hàng nào.</p>
                    @endif
                </ul>

            </div>
        </div>
    </div>


@endsection

@push('script')
<script type="text/javascript" src="{{ asset ('js/order.js') }}"></script>
@endpush