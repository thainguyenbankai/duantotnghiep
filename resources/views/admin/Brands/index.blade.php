@extends('admin.main_admin')

@section('title', 'Danh sách Thương hiệu')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="text-xxl font-bold mb-4 text-center">DANH SÁCH THƯƠNG HIỆU</h2>

    <!-- Nút thêm và thùng rác -->
    <div class="row mb-3">
        <div class="col-md-6">
            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle"></i> Thêm Thương Hiệu
            </a>
            <a href="{{ route('admin.trash_brands') }}" class="btn btn-success">
                <i class="fas fa-trash-alt"></i> Thùng Rác
            </a>
        </div>
        <!-- Form tìm kiếm -->
        <div class="col-md-6">
            <form action="{{ route('admin.brands.index') }}" method="GET" class="d-flex justify-content-end" style="display: flex;">
                <input type="text" name="search" placeholder="Tìm kiếm thương hiệu" class="form-control me-2" value="{{ request()->get('search') }}">
                <button type="submit" class="btn btn-info">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </form>
        </div>
    </div>

    @if(session('search'))
    <div class="alert alert-info text-end">
        Tìm thấy {{ session('search') }} kết quả
    </div>
    @endif

    <!-- Bảng hiển thị danh sách -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>STT</th>
                    <th>Thương hiệu</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo</th>
                    <th>Người tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($brands as $brand)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $brand->name }}</td>
                    <td>{{ $brand->description }}</td>
                    <td>{{ $brand->date_create->format('d/m/Y') }}</td>
                    <td>{{ $brand->status }}</td>
                    <td class="d-flex justify-content-center" style="display: flex">
                        <a href="{{ route('admin.brands.edit', $brand->id) }}" class="btn btn-sm btn-warning me-2">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
                @if($brands->isEmpty())
                <tr>
                    <td colspan="7" class="text-center">Không có thương hiệu nào.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- Phân trang -->
    <div class="d-flex justify-content-center mt-3">
        {{ $brands->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
