@extends('admin.main_admin')

@section('title', 'Thêm Danh Mục')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="text-2xl font-bold mb-4 text-center">Thêm Danh Mục Mới</h2>

    <div class="bg-white p-5 rounded shadow-md">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <!-- Tên Danh Mục -->
            <div class="mb-4">
                <label for="name" class="form-label">Tên Danh Mục</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Mô Tả -->
            <div class="mb-4">
                <label for="description" class="form-label">Mô Tả</label>
                <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror"></textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nút Thêm và Trở Về -->
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Trở về</a>
                <button type="submit" class="btn btn-success">Thêm Danh Mục</button>
            </div>
        </form>
    </div>
</div>
@endsection
