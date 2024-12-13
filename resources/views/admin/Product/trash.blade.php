@extends('admin.main_admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-xxl font-bold mb-4 text-center">THÙNG RÁC SẢN PHẨM</h2>

        <!-- Nút thêm và thùng rác -->
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Quay về
                </a>
            </div>
            <!-- Form tìm kiếm -->
            <div class="col-md-6">
                <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex justify-content-end"
                    style="display: flex;">
                    <input type="text" name="search" placeholder="Tìm sản phẩm" class="form-control me-2"
                        value="{{ request()->get('search') }}">
                    <button type="submit" class="btn btn-info">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </form>
            </div>
        </div>

        @if (session('search'))
            <div class="alert alert-info text-end">
                Tìm thấy {{ session('search') }} kết quả
            </div>
        @endif

        <!-- Bảng hiển thị sản phẩm -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Trạng thái</th>
                        <th>Thương hiệu</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $product->name }}</td>
                            <td>
                                @if ($product->images)
                                    @php
                                        $images = json_decode($product->images); // Giải mã JSON chứa danh sách hình ảnh
                                    @endphp
                                    @if (!empty($images) && isset($images[0]))
                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="{{ $product->name }}"
                                            width="80px">
                                    @else
                                        <span>Chưa có hình ảnh</span>
                                    @endif
                                @else
                                    <span>Chưa có hình ảnh</span>
                                @endif
                            </td>
                            <td>{{ number_format($product->price, 2) }} VNĐ</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->status_id == 1 ? 'Còn hàng' : 'Hết hàng' }}</td>
                            <td>{{ $product->brand ? $product->brand->name : 'Không có thương hiệu' }}</td>
                            <td>{{ $product->created_at->format('d/m/Y') }}</td>
                            <td class="d-flex justify-content-center" style="display: flex">
                                <!-- Khôi phục sản phẩm -->
                                @if ($product->trashed())
                                    <a href="{{ route('admin.products.restore', ['id' => $product->id]) }}"
                                        class="btn btn-sm btn-warning me-2">
                                        <i class="fas fa-edit"></i> Khôi phục
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Không có sản phẩm nào.</td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-3">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
