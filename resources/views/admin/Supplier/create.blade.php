
@extends('admin.main_admin')

@section('title', 'Thêm Nhà cung cấp')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">THÊM NHÀ CUNG CẤP</h2>

    <form action="{{ route('admin.suppliers.store') }}" method="POST">
        @csrf
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Tên Nhà cung cấp</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-500 text-white m-1 px-4 py-2 rounded hover:bg-blue-600 transition">Trở về</button>
                <button type="submit" class="bg-blue-500 m-1 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                    Lưu
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
