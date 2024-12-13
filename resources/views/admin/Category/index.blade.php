@extends('admin.main_admin')

@section('title', 'Danh sách Danh Mục')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-xxl font-bold mb-4 text-center">DANH SÁCH DANH MỤC</h2>

        <!-- Nút thêm và thùng rác -->
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Thêm Danh Mục
                </a>
                <a href="{{ route('admin.trash_categories') }}" class="btn btn-primary">
                    <i class="fas fa-trash"></i> Thùng rác
                </a>
            </div>

            <!-- Form tìm kiếm -->
            <div class="col-md-6">
                <form action="{{ route('admin.categories.index') }}" method="GET" class="d-flex justify-content-end"
                    style="display: flex">
                    <input type="text" name="search" placeholder="Tìm kiếm danh mục" class="form-control me-2"
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

        <!-- Bảng danh sách danh mục -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr class="text-center fw-bold">
                        <th>STT</th>
                        <th>Tên Danh Mục</th>
                        <th>Mô Tả</th>
                        <th>Ngày Tạo</th>
                        <th>Người Tạo</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td class="text-center">{{ $category->date_create->format('d/m/Y') }}</td>
                            <td class="text-center">{{ $category->status }}</td>
                            <td class="d-flex justify-content-center" style="display: flex">
                                <a href="{{ route('admin.categories.edit', $category->id) }}"
                                    class="btn btn-sm btn-warning me-2">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($categories->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">Không có danh mục nào.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-3">
            {{ $categories->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
