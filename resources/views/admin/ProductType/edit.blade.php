<!-- resources/views/admin/productTypess/edit.blade.php -->

@extends('admin.main_admin')

@section('title', 'Sửa Kiểu Sản Phẩm')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">SỬA KIỂU SẢN PHẨM</h2>

    <form action="{{ route('admin.productTypes.update', $productType->id) }}" method="POST" class="max-w-lg mx-auto">
        @csrf
        @method('PUT')

        <!-- Tên Kiểu Sản Phẩm -->
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Tên Kiểu Sản Phẩm</label>
            <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" value="{{ old('name', $productType->name) }}" required>
            @error('name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Mô Tả -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Mô Tả</label>
            <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">{{ old('description', $productType->description) }}</textarea>
            @error('description')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Trạng Thái -->
        <div class="mb-4">
            <label for="status" class="block text-gray-700 font-semibold mb-2">Trạng Thái</label>
            <select name="status" id="status" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" required>
                <option value="show" {{ $productType->status == 'show' ? 'selected' : '' }}>Hiển Thị</option>
                <option value="hidden" {{ $productType->status == 'hidden' ? 'selected' : '' }}>Ẩn</option>
            </select>
            @error('status')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-6 text-center">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Cập Nhật Kiểu Sản Phẩm</button>
        </div>
    </form>
</div>
@endsection
