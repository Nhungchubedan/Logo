@extends('layouts.admin')
@section('title', 'Quản lý thương hiệu')
@section('content')

<div class="admin-content">
    <p class="fw-bold text-success fs-4">DANH SÁCH THƯƠNG HIỆU</p>
    <div class="d-flex justify-content-between position-relative  mb-2 mt-3">
        <input style="width:40%;" id="search" type="text" class="py-2 fs-sm px-10 rounded-3 border border-black" placeholder="Tìm kiếm thương hiệu">
        <i class="fa-solid fs-6 fa-magnifying-glass text-black position-absolute start-0 mt-3 mx-3"></i>
        <button class="btn fs-sm fw-bold text-white bg-success p-2 rounded-2 float-end">
            <i class="fa-solid fa-plus"></i> Thêm
        </button>
        @include('admin.components.crudBrand', ['action' => 'add'])
        
    </div>
    <table id="data-table">
        <thead>
            <tr class="head">
                <th>Mã thương hiệu</th>
                <th>Tên thương hiệu</th>
                <th>Ảnh minh họa</th>
                <th>Quốc gia</th>
                <th>Mô tả</th>
                <th>URL</th>
                <th>Cập nhập</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $brand)
            <tr>
                <td>{{ $brand->id_brand }}</td>
                <td>{{ $brand->brand_name }}</td>
                <td>
                    <img 
                    src="{{ asset('img/'.$brand->image->image_url) }}" 
                    style="width:80px;aspect-ratio: 1 / 1;"
                    class="object-fit-cover rounded-circle">
                </td>
                <td>{{ $brand->nation }}</td>
                <td>{{ $brand->description }}</td>
                <td style="word-break:break-all;">{{ $brand->website_url ?? 'NULL' }}</td>
                <td>{{ $brand->updated_at }}</td>
                <td>
                    <div class="btn d-inline-block">
                        <i class="fa-solid fa-pencil fs-6 text-primary"></i>
                        @include('admin.components.crudBrand', [
                            'data' => $brand,
                            'action' => 'update',
                        ])
                    </div>&ensp;
                    <div role="button" class="btn-confirm d-inline-block">
                        <i class="fa-solid fa-trash fs-6 text-danger"></i>
                        @include('admin.components.confirm', [
                            'route' => 'admin.brand.destroy',
                            'id' => $brand->id_brand
                        ])
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody> 
            

    </table>
</div>

@endsection
