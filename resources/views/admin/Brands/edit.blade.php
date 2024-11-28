@extends('admin.main_admin')

@section('title', 'Sửa Thương Hiệu')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="text-xxl font-bold mb-4 text-center">SỬA THƯƠNG HIỆU</h2>

    <!-- Form sửa thương hiệu -->
    <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Tên Thương Hiệu</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $brand->name) }}">
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô Tả</label>
            <textarea name="description" class="form-control" id="description">{{ old('description', $brand->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection
