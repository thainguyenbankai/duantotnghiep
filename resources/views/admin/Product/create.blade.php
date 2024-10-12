@extends('admin.main_admin')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">Thêm Sản Phẩm</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <!-- Tên sản phẩm -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Giá sản phẩm -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Giá sản phẩm</label>
                <input type="number" name="price" id="price" step="10" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Số lượng sản phẩm</label>
                <input type="number" name="quantity" id="price" step="1" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

           
            <div>
                <label for="brand_id" class="block text-sm font-medium text-gray-700">Thương hiệu</label>
                <select name="brand_id" id="brand_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Chọn thương hiệu</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Nhà cung cấp -->
            <div>
                <label for="supplier_id" class="block text-sm font-medium text-gray-700">Nhà cung cấp</label>
                <select name="supplier_id" id="supplier_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Chọn nhà cung cấp</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Loại sản phẩm -->
             <div>
                <label for="type_id" class="block text-sm font-medium text-gray-700">Loại sản phẩm</label>
                <select name="type_id" id="type_id" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Chọn kiểu sản phẩm</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                    @endforeach
                </select>
            </div> 
            <!-- Danh mục sản phẩm -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục sản phẩm</label>
                <select name="category_id" id="category_id" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

           

            <!-- Mô tả sản phẩm -->
            <div class="md:col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả sản phẩm</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div class="md:col-span-2">
                <label for="image" class="block text-sm font-medium text-gray-700">Hình ảnh sản phẩm</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>
            
            

        </div>

        <!-- Nút submit -->
        <div class="text-start">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Thêm sản phẩm</button>
            <button type="reset" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">Hủy bỏ</button>
        </div>
    </form>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

</div>
@endsection
