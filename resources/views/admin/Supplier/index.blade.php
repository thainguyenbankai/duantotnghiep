<!-- resources/views/admin/suppliers/index.blade.php -->

@extends('admin.main_admin')

@section('title', 'Danh sách Nhà cung cấp')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">DANH SÁCH NHÀ CUNG CẤP</h2>

    <!-- Thêm nút Thêm Nhà cung cấp -->
    <div class="mb-4 flex justify-between items-center">
        <a href="{{ route('admin.suppliers.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Thêm Nhà cung cấp</a>

        <!-- Ô tìm kiếm -->
        <div>
            <form action="{{ route('admin.suppliers.index') }}" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm Nhà cung cấp" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" value="{{ request()->get('search') }}">
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
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tên Nhà cung cấp</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mô tả</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Người tạo</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày tạo</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium text-gray-700">
                @foreach($suppliers as $supplier)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $supplier->name }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $supplier->description }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $supplier->status }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $supplier->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" class="text-blue-500 hover:underline">Sửa</a>
                        <form action="{{ route('admin.suppliers.destroy', $supplier->id) }}" method="POST" class="inline-block ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Xóa</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if ($suppliers->isEmpty())
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Không có nhà cung cấp nào.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    {{-- <div class="mt-4">
        {{ $suppliers->links() }}
    </div> --}}
</div>
<br>
<br>
@endsection
