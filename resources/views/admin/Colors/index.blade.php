@extends('admin.main_admin')

@section('title', 'Danh sách Danh Mục')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-xxl font-bold mb-4 text-center">DANH SÁCH MÀU SẮC</h2>

        <!-- Nút thêm và thùng rác -->
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Thêm Màu sắc
                </a>
                <a href="{{ route('admin.trash_colors') }}" class="btn btn-success ms-2">
                    <i class="fas fa-trash"></i> Thùng Rác
                </a>
            </div>


        </div>

        @if (session('search'))
            <div class="alert alert-info text-end">
                Tìm thấy {{ session('search') }} kết quả
            </div>
        @endif

        <!-- Bảng danh sách danh mục -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover ">
                <thead class="table-light">
                    <tr class="text-center fw-bold">
                        <th>STT</th>
                        <th>Tên màu sắc</th>
                        <th>Ngày Tạo</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($colors as $color)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $color->name }}</td>
                            <td>{{ $color->created_at->format('d/m/Y') }}</td>
                            <td class="d-flex justify-content-center" style="display: flex">
                                <a href="{{ route('admin.colors.edit', $color->id) }}" class="btn btn-sm btn-warning me-2">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.colors.destroy', $color->id) }}" method="POST"
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

                    @if ($colors->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">Không có danh mục nào.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-3">
            {{ $colors->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
