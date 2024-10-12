@extends('admin.main_admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">Danh Sách Sản Phẩm</h2>

    <!-- Ô tìm kiếm sản phẩm -->
    <div class="flex justify-between mb-4">
        <a href="{{ route('admin.products.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Thêm sản phẩm</a>
        
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" placeholder="Tìm sản phẩm..." class="border border-gray-300 px-4 py-2 rounded-l-md focus:ring-blue-500 focus:border-blue-500">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 transition">Tìm kiếm</button>
        </form>
    </div>

    <!-- Bảng hiển thị sản phẩm -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">STT</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tên sản phẩm</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hình ảnh</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Giá</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tồn kho</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Thương hiệu</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nhà cung cấp</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày tạo</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium text-gray-700">
                @forelse($products as $index => $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b border-gray-200">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $product->name }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        @if($product->image)
                            <img src="{{ asset('/storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover">
                        @else
                            <span>Chưa có hình ảnh</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ number_format($product->price, 2) }} VNĐ</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $product->quantity }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        {{ $product->status_id == 1 ? 'Còn hàng' : 'Hết hàng' }}
                    </td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $product->brand ? $product->brand->name : 'Không có thương hiệu' }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $product->supplier ? $product->supplier->name : 'Không có nhà cung cấp' }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">{{ $product->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="text-blue-500 hover:underline">Sửa</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline ml-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-4 text-center text-gray-500">Không có sản phẩm nào.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="mt-6">
        {{-- {{ $products->links() }} --}}
    </div>
</div>
@endsection
