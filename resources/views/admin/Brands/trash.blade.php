
@extends('admin.main_admin')

@section('title', 'Danh sách Thương hiệu')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">DANH SÁCH THƯƠNG HIỆU</h2>

    <!-- Thêm nút Thêm thương hiệu -->
    <div class="mb-4 flex justify-between items-center">
        <div>
        <a href="{{ route('admin.brands.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Thêm thương hiệu</a>
        <a href="{{ route('admin.brands.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Thùng rác</a>
            
        </div>

        <!-- Ô tìm kiếm -->
        <div>
            <form action="{{ route('admin.brands.index') }}" method="GET">
                <input type="text" name="search" placeholder="Tìm kiếm thương hiệu" class="px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500" value="{{ request()->get('search') }}">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Tìm kiếm</button>
            </form>
        </div>
    </div>
    @if(session('search'))
    <div class="flex justify-end mb-4">
        Tìm thấy {{ session('search') }} kết quả
    </div>
@endif
    <!-- Bảng thương hiệu -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">STT</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thương hiệu</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mô tả</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày tạo</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Người tạo</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium text-gray-700">
                @foreach($brands as $brand)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b border-gray-200">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $brand->name }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $brand->description }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $brand->date_create->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $brand->status }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        @if($brand->trashed())
                        <a href="{{ route('admin.restore_brand', ['id' => $brand->id]) }}" class="text-green-500 hover:underline ml-4" onclick="return confirm('Bạn có chắc chắn muốn khôi phục sản phẩm này?')">Khôi phục</a>
                    @endif
                    </td>
                </tr>
                
                @endforeach
                @if($brands->isEmpty())
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Không có thương hiệu nào.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- <!-- Phân trang -->
    <div class="mt-4">
        {{ $brands->links() }}
    </div> --}}
</div>
<br>
<br>
@endsection
