@extends('admin.main_admin')

@section('title', 'Thêm Danh Mục')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4">Thêm Danh Mục Mới</h2>
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-semibold mb-2">Tên Danh Mục</label>
                <input type="text" id="name" name="name" class="form-input mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 text-sm font-semibold mb-2">Mô Tả</label>
                <textarea id="description" name="description" rows="4" class="form-textarea mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.categories.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Trở về</a>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50">Thêm Danh Mục</button>
            </div>
        </form>
    </div>
</div>
@endsection
