@extends('layouts.admin')
@section('title', 'Quản lý danh mục')
@section('content')

<div class="admin-content">
    <p class="fw-bold text-success fs-4">DANH SÁCH DANH MỤC</p>
    <div class="d-flex justify-content-between position-relative mb-2 mt-3">
        <input style="width:40%;" id="search" type="text" class="py-2 fs-sm px-10 rounded-3 border border-black" placeholder="Tìm kiếm danh mục">
        <i class="fa-solid fs-6 fa-magnifying-glass text-black position-absolute start-0 mt-3 mx-3"></i>
        <button class="btn fs-sm fw-bold text-white bg-success p-2 rounded-2 float-end">
            <i class="fa-solid fa-plus"></i> Thêm
        </button>
        @include('admin.components.crudCategory', ['action' => 'add'])
    </div>
    <table class="" id="data-table">
        <thead>
            <tr class="head">
                <th>Mã danh mục</th>
                <th>Tên danh mục</th>
                <th>Ảnh minh họa</th>
                <th>Ngày tạo</th>
                <th>Cập nhập</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $category)
            <tr>
                <td>{{ $category->id_category }}</td>
                <td>{{ $category->category_name }}</td>
                <td>
                    <img 
                    src="{{ asset('img/' . $category->image->image_url)}}" 
                    style="width:80px;aspect-ratio: 1 / 1;"
                    class="object-fit-cover rounded-circle">
                </td>
                <td>{{ $category->created_at }}</td>
                <td>{{ $category->updated_at }}</td>
                <td>
                <div class="btn d-inline-block">
                        <i class="fa-solid fa-pencil fs-6 text-primary"></i>
                        @include('admin.components.crudCategory', [
                            'data' => $category,
                            'action' => 'update',
                        ])
                    </div>&ensp;
                    <div role="button" class="btn-confirm d-inline-block">
                        <i class="fa-solid fa-trash fs-6 text-danger"></i>
                        @include('admin.components.confirm', [
                            'route' => 'admin.category.destroy',
                            'id' => $category->id_category
                        ])
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

    </div>
</div>

@endsection