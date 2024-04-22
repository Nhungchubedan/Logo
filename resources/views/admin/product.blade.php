@extends('layouts.admin')
@section('title', 'Quản lý sản phẩm')
@section('content')

<div class="admin-content">
    <p class="fw-bold text-success fs-4">DANH SÁCH SẢN PHẨM</p>
    <div class="d-flex justify-content-between position-relative mb-2 mt-3">
        <input style="width:40%;" id="search" type="text" class="py-2 fs-sm px-10 rounded-3 border border-black" placeholder="Tìm kiếm sản phẩm">
        <i class="fa-solid fs-6 fa-magnifying-glass text-black position-absolute start-0 mt-3 mx-3"></i>
        <button class="btn fs-sm fw-bold text-white bg-success p-2 rounded-2 float-end">
            <i class="fa-solid fa-plus"></i> Thêm
        </button>
        @include('admin.components.crudProduct', ['action' => 'add'])
    </div>
    <table class="" id="data-table">
        <thead>
            <tr class="head">
                <th>Mã sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Đơn giá</th>
                <th>Giảm giá</th>
                <th>Đã bán</th>
                <th>Tồn kho</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Cập nhập</th>
                <th>Thao tác</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($data as $item)
            <tr>
                <td>{{ $item['product']->id_product }}</td>
                <td>{{ $item['product']->product_name }}</td>
                <td>{{ number_format($item['product']->unit_price, 0, '', '.') }} đ</td>
                <td>{{ $item['product']->discount }} %</td>
                <td>{{ $item['totalQuantity'] }}</td>
                <td>{{ number_format($item['product']->iventory, 0, '', '.') }} </td>
                <td>{{ $item['product']->category->category_name ?? 'NULL' }}</td>
                <td>{{ $item['product']->brand->brand_name ?? 'NULL' }}</td>
                <td>{{ $item['product']->updated_at }}</td>
                <td>
                    <div class="btn d-inline-block">
                        <i class="fa-solid fa-pencil fs-6 text-primary"></i>
                        @include('admin.components.crudProduct', [
                            'data' => $item['product'],
                            'action' => 'update',
                        ])
                    </div>&ensp;
                    <div role="button" class="btn-confirm d-inline-block">
                        <i class="fa-solid fa-trash fs-6 text-danger"></i>
                        <form class="confirm-dialog" method="post">
                            @csrf
                            <input type="hidden" name="id_product" value="{{ $item['product']->id_product }}">
                            <div class="dialog rounded-3 relative text-start">
                                <i class="fa-solid fa-xmark quit-dialog"></i>
                                <h4 class="fs-5 fw-bold w-100 text-danger">Xác nhận</h4>
                                <p class="text-black fs-6">Bạn có chắc chắn muốn xóa bản ghi này?</p>
                                <div class="mt-4 float-end">
                                    <button type="submit" name="action" value="delete" class="px-4 py-2 text-white fw-bold bg-danger rounded-5 fs-sm" name="cancel-order">XÁC NHẬN</button>
                                </div>
                            </div>
                        </form>
                    </div>&ensp;
                    <div class="btn">
                        <i class="fa-solid fa-circle-info fs-6 text-success"></i>
                        @include('admin.components.detailProduct', [
                            'data'      => $item['product'],
                            'brand'     => $brand,
                            'category'  => $category
                        ])
                    </div>
                    
                </td>
            </tr>
            @endforeach
        </tbody>

</table>
</div>

@endsection