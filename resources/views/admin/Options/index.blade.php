@extends('admin.main_admin')

@section('title', 'Danh sách thông số')

@section('content')
    <div class="container-fluid mt-4">
        <h2 class="text-xxl font-bold mb-4 text-center">DANH SÁCH THÔNG SỐ</h2>

        <!-- Nút thêm và thùng rác -->
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('admin.options.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Thêm thông số
                </a>
                <a href="{{ route('admin.trash_options') }}" class="btn btn-success ms-2">
                    <i class="fas fa-trash"></i> Thùng Rác
                </a>
            </div>

         =
        </div>

        @if (session('search'))
            <div class="alert alert-info text-end">
                Tìm thấy {{ session('search') }} kết quả
            </div>
        @endif

        <!-- Bảng danh sách thông số -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover ">
                <thead class="table-light">
                    <tr class="text-center fw-bold">
                        <th>STT</th>
                        <th>RAM</th>
                        <th>ROM</th>
                        <th>Ngày Tạo</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($options as $option)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $option->ram }}</td>
                            <td>{{ $option->rom }}</td>
                            <td>{{ $option->created_at->format('d/m/Y') }}</td>
                            <td class="d-flex justify-content-center" style="display: flex">
                                <a href="{{ route('admin.options.edit', $option->id) }}"
                                    class="btn btn-sm btn-warning me-2">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <form action="{{ route('admin.options.destroy', $option->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa thông số này?')">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($options->isEmpty())
                        <tr>
                            <td colspan="6" class="text-center text-muted">Không có thông số nào.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-3">
            {{ $options->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
