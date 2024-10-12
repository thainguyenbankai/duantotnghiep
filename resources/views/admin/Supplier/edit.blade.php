@extends('admin.main_admin')

@section('title', 'Sửa Nhà Cung Cấp')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">SỬA NHÀ CUNG CẤP</h2>

    <form action="{{ route('admin.suppliers.update', $supplier->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Tên Nhà Cung Cấp</label>
                <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                <input type="text" name="description" id="description" value="{{ old('description', $supplier->description) }}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('address') border-red-500 @enderror">
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

          

            <div class="flex justify-end">
                <button type="reset"
                    class="bg-green-500 p-4 m-1 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Hủy bỏ</button>
                <button type="submit"
                    class="bg-blue-500 p-4 m-1 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Lưu</button>
            </div>
        </div>
    </form>
</div>
@endsection
