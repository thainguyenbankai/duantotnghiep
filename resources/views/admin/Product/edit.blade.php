@extends('admin.main_admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container-fluid mx-auto mt-10">
    <h2 class="text-3xl font-bold mb-4 text-center">Chỉnh sửa Sản Phẩm</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <!-- Các trường nhập liệu chính -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

            <!-- Tên sản phẩm -->
            <div>
                <label for="name" class="block text-lg font-medium text-gray-700">Tên sản phẩm</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-lg">
            </div>

            <!-- Giá sản phẩm -->
            <div>
                <label for="price" class="block text-lg font-medium text-gray-700">Giá sản phẩm</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="1" required
                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-lg">
            </div>

            <!-- Số lượng sản phẩm -->
            <div>
                <label for="quantity" class="block text-lg font-medium text-gray-700">Số lượng sản phẩm</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" step="1" required
                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-lg">
            </div>

            <!-- Thương hiệu -->
            <div>
                <label for="brand_id" class="block text-lg font-medium text-gray-700">Thương hiệu</label>
                <select name="brand_id" id="brand_id"
                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-lg">
                    <option value="">Chọn thương hiệu</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Danh mục sản phẩm -->
            <div>
                <label for="category_id" class="block text-xxl font-medium text-gray-700">Danh mục sản phẩm</label>
                <select name="category_id" id="category_id"
                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-lg">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="col-span-2">
                <label for="description" class="block text-lg font-medium text-gray-700">Mô tả sản phẩm</label>
                <textarea name="description" id="description" rows="4" required
                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-lg">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div>
                <label for="image" class="block text-lg font-medium text-gray-700">Hình ảnh sản phẩm</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-lg text-gray-700 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @if($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="w-32 h-32 object-cover">
                    </div>
                @endif
            </div>
        </div>

        <!-- Phần biến thể sản phẩm -->
        <div id="variants" class="mb-6">
            <h3 class="text-xl font-bold mb-2">Biến thể sản phẩm</h3>
            <div class="variant-group space-y-4">
                @foreach($product->variants as $variantIndex => $variant)
                    <div class="flex items-center justify-between mb-4 border p-4 rounded-md shadow-sm variant-item" data-index="{{ $variantIndex }}">
                        <div class="flex flex-col space-y-4 w-full">
                            <div class="grid grid-cols-2 gap-4">
                                <select name="variants[{{ $variantIndex }}][ram]" required class="block w-full px-4 py-3 border border-gray-300 rounded-md text-lg">
                                    <option value="">Chọn RAM</option>
                                    <option value="4GB" {{ old('variants.' . $variantIndex . '.ram', $variant->ram) == '4GB' ? 'selected' : '' }}>4GB</option>
                                    <option value="6GB" {{ old('variants.' . $variantIndex . '.ram', $variant->ram) == '6GB' ? 'selected' : '' }}>6GB</option>
                                    <option value="8GB" {{ old('variants.' . $variantIndex . '.ram', $variant->ram) == '8GB' ? 'selected' : '' }}>8GB</option>
                                    <option value="12GB" {{ old('variants.' . $variantIndex . '.ram', $variant->ram) == '12GB' ? 'selected' : '' }}>12GB</option>
                                </select>
                                <select name="variants[{{ $variantIndex }}][rom]" required class="block w-full px-4 py-3 border border-gray-300 rounded-md text-lg">
                                    <option value="">Chọn ROM</option>
                                    <option value="64GB" {{ old('variants.' . $variantIndex . '.rom', $variant->rom) == '64GB' ? 'selected' : '' }}>64GB</option>
                                    <option value="128GB" {{ old('variants.' . $variantIndex . '.rom', $variant->rom) == '128GB' ? 'selected' : '' }}>128GB</option>
                                    <option value="256GB" {{ old('variants.' . $variantIndex . '.rom', $variant->rom) == '256GB' ? 'selected' : '' }}>256GB</option>
                                    <option value="512GB" {{ old('variants.' . $variantIndex . '.rom', $variant->rom) == '512GB' ? 'selected' : '' }}>512GB</option>
                                </select>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <input type="number" name="variants[{{ $variantIndex }}][price]" value="{{ old('variants.' . $variantIndex . '.price', $variant->price) }}" placeholder="Giá" required class="block w-full px-4 py-3 border border-gray-300 rounded-md text-lg">
                                <input type="number" name="variants[{{ $variantIndex }}][stock]" value="{{ old('variants.' . $variantIndex . '.stock', $variant->stock) }}" placeholder="Số lượng" required class="block w-full px-4 py-3 border border-gray-300 rounded-md text-lg">
                            </div>
                            <div class="mt-4">
                                <label class="block text-lg font-medium text-gray-700">Chọn màu sắc</label>
                                <div class="flex space-x-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="variants[{{ $variantIndex }}][color][]" value="Trắng" class="form-checkbox h-5 w-5 text-gray-700" {{ in_array('Trắng', old('variants.' . $variantIndex . '.color', $variant->color)) ? 'checked' : '' }}>
                                        <span class="ml-2">Trắng</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="variants[{{ $variantIndex }}][color][]" value="Đen" class="form-checkbox h-5 w-5 text-gray-700" {{ in_array('Đen', old('variants.' . $variantIndex . '.color', $variant->color)) ? 'checked' : '' }}>
                                        <span class="ml-2">Đen</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="variants[{{ $variantIndex }}][color][]" value="Xanh" class="form-checkbox h-5 w-5 text-gray-700" {{ in_array('Xanh', old('variants.' . $variantIndex . '.color', $variant->color)) ? 'checked' : '' }}>
                                        <span class="ml-2">Xanh</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeVariant(this)">Xóa biến thể</button>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="mt-4 px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700" onclick="addVariant()">Thêm biến thể</button>
        </div>

        <div class="mt-8 flex justify-center">
            <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Cập nhật sản phẩm</button>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    function addVariant() {
        let variantGroup = document.querySelector('.variant-group');
        let variantIndex = variantGroup.children.length;
        let variantHTML = `
            <div class="flex items-center justify-between mb-4 border p-4 rounded-md shadow-sm variant-item" data-index="${variantIndex}">
                <div class="flex flex-col space-y-4 w-full">
                    <div class="grid grid-cols-2 gap-4">
                        <select name="variants[${variantIndex}][ram]" required class="block w-full px-4 py-3 border border-gray-300 rounded-md text-lg">
                            <option value="">Chọn RAM</option>
                            <option value="4GB">4GB</option>
                            <option value="6GB">6GB</option>
                            <option value="8GB">8GB</option>
                            <option value="12GB">12GB</option>
                        </select>
                        <select name="variants[${variantIndex}][rom]" required class="block w-full px-4 py-3 border border-gray-300 rounded-md text-lg">
                            <option value="">Chọn ROM</option>
                            <option value="64GB">64GB</option>
                            <option value="128GB">128GB</option>
                            <option value="256GB">256GB</option>
                            <option value="512GB">512GB</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="number" name="variants[${variantIndex}][price]" placeholder="Giá" required class="block w-full px-4 py-3 border border-gray-300 rounded-md text-lg">
                        <input type="number" name="variants[${variantIndex}][stock]" placeholder="Số lượng" required class="block w-full px-4 py-3 border border-gray-300 rounded-md text-lg">
                    </div>
                    <div class="mt-4">
                        <label class="block text-lg font-medium text-gray-700">Chọn màu sắc</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="variants[${variantIndex}][color][]" value="Trắng" class="form-checkbox h-5 w-5 text-gray-700">
                                <span class="ml-2">Trắng</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="variants[${variantIndex}][color][]" value="Đen" class="form-checkbox h-5 w-5 text-gray-700">
                                <span class="ml-2">Đen</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="variants[${variantIndex}][color][]" value="Xanh" class="form-checkbox h-5 w-5 text-gray-700">
                                <span class="ml-2">Xanh</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <button type="button" class="text-red-500 hover:text-red-700" onclick="removeVariant(this)">Xóa biến thể</button>
                </div>
            </div>
        `;
        variantGroup.insertAdjacentHTML('beforeend', variantHTML);
    }

    function removeVariant(button) {
        button.closest('.variant-item').remove();
    }
</script>
@endsection
