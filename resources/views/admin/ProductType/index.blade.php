<!-- resources/views/admin/productTypess/index.blade.php -->

@extends('admin.main_admin')

@section('title', 'Danh sách Kiểu Sản phẩm')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">DANH SÁCH KIỂU SẢN PHẨM P</h2>

    <!-- Thêm nút Thêm Nhà cung cấp -->
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('admin.productTypes.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Thêm Nhà cung cấp</a>

        <!-- Ô tìm kiếm -->
        <div>
            <form action="{{ route('admin.productTypes.index') }}" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm kiểu sản phẩm" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" value="{{ request()->get('search') }}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Tìm kiếm</button>
            </form>
        </div>
    </div>
    @if(session('search'))
    <div class="flex justify-end mb-4">
        Tìm thấy {{ session('search') }} kết quả
    </div>
@endif
    <!-- Bảng Nhà cung cấp -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">STT</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kiểu sản phẩm</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mô tả</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày tạo</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium text-gray-700">
                @foreach($productTypes as $productType)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $productType->type }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $productType->description }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $productType->date_create->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <a href="{{ route('admin.productTypes.edit', $productType->id) }}" class="text-blue-500 hover:underline">Sửa</a>
                        <form action="{{ route('admin.productTypes.destroy', $productType->id) }}" method="POST" class="inline-block ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if ($productTypes->isEmpty())
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Không có nhà cung cấp nào.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    {{-- <div class="mt-4">
        {{ $productTypes->links() }}
    </div> --}}
</div>
<br>
<br>
@endsection
