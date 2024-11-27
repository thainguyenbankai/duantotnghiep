    <!-- resources/views/admin/reviews/edit.blade.php -->

@extends('admin.main_admin')

@section('title', 'Sửa Thương hiệu')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">SỬA BÌNH LUẬN</h2>

    <form action="{{ route('admin.reviews.update', $review->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="review_text" class="block text-sm font-medium text-gray-700">Bình luận</label>
            <textarea id="review_text" name="review_text" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">{{ old('review_text', $review->review_text) }}</textarea>
            @error('review_text')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="rating" class="block text-sm font-medium text-gray-700">Đánh giá</label>
            <input type="number" id="rating" name="rating" min="1" max="5" value="{{ old('rating', $review->rating) }}" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
            @error('rating')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Trạng thái</label>
            <select id="status" name="status" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-blue-500">
                <option value="1" {{ old('status', $review->status) == 1 ? 'selected' : '' }}>Hiện</option>
                <option value="0" {{ old('status', $review->status) == 0 ? 'selected' : '' }}>Ẩn</option>
            </select>
            @error('status')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Cập nhật</button>
        </div>
    </form>
</div>
@endsection
