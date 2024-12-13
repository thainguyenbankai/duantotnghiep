@extends('admin.main_admin')

@section('title', 'Danh sách người dùng')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="text-xxl font-bold mb-4 text-center">DANH SÁCH NGƯỜI DÙNG</h2>
    <div class="row mb-3">
        <!-- Form tìm kiếm -->
        <div class="col-md-6">
            <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex justify-content-end" style="display: flex">
                <input type="text" name="search" placeholder="Tìm kiếm người dùng" class="form-control me-2" value="{{ request()->get('search') }}">
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

    <!-- Bảng danh sách người dùng -->
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr class="text-center fw-bold">
                    <th>STT</th>
                    <th>Tên người dùng</th>
                    <th>Email</th>
                    <th>Ngày Tạo</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="text-center">{{ $user->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <select name="keyy" class="form-select form-control  " onchange="this.form.submit()">
                                <option value="active" {{ $user->keyy == 'active' ? 'selected' : '' }}>Kích hoạt</option>
                                <option value="inactive" {{ $user->keyy == 'inactive' ? 'selected' : '' }}>Tạm khóa</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @endforeach
            
                @if($users->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-muted">Không có người dùng nào.</td>
                </tr>
                @endif
            </tbody>
            
        </table>
    </div>
</div>
@endsection
