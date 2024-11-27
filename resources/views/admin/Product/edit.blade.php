@extends('admin.main_admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">Chỉnh sửa Sản Phẩm</h2>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Tên sản phẩm -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Giá sản phẩm -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Giá sản phẩm</label>
                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="1" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Số lượng sản phẩm -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Số lượng sản phẩm</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" step="1" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Thương hiệu -->
            <div>
                <label for="brand_id" class="block text-sm font-medium text-gray-700">Thương hiệu</label>
                <select name="brand_id" id="brand_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Chọn thương hiệu</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Loại sản phẩm -->
            <div>
                <label for="type_id" class="block text-sm font-medium text-gray-700">Loại sản phẩm</label>
                <select name="type_id" id="type_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Chọn loại sản phẩm</option>
                    @foreach($types as $type)
                        <option value="{{ $type->id }}" {{ old('type_id', $product->type_id) == $type->id ? 'selected' : '' }}>{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Danh mục sản phẩm -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700">Danh mục sản phẩm</label>
                <select name="category_id" id="category_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Chọn danh mục</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả sản phẩm</label>
                <textarea name="description" id="description" rows="4" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Hình ảnh sản phẩm</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                @if($product->image)
                    <img src="{{ asset('storage/'.$product->image) }}" alt="Product Image" class="mt-2 w-32">
                @endif
            </div>
        </div>

        <!-- Phần biến thể sản phẩm -->
        <div id="variants" class="mb-6">
            <h3 class="text-lg font-bold mb-2">Biến thể sản phẩm</h3>
            <div class="variant-group space-y-4">
                @foreach($product->variants as $index => $variant)
                    <div class="flex items-center justify-between mb-4 border p-4 rounded-md shadow-sm">
                        <div class="flex space-x-4">
                            <select name="variants[{{ $index }}][ram]" required
                                class="mt-1 block w-full px-10 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Chọn RAM</option>
                                <option value="4GB" {{ old('variants.'.$index.'.ram', $variant->ram) == '4GB' ? 'selected' : '' }}>4GB</option>
                                <option value="6GB" {{ old('variants.'.$index.'.ram', $variant->ram) == '6GB' ? 'selected' : '' }}>6GB</option>
                                <option value="8GB" {{ old('variants.'.$index.'.ram', $variant->ram) == '8GB' ? 'selected' : '' }}>8GB</option>
                                <option value="12GB" {{ old('variants.'.$index.'.ram', $variant->ram) == '12GB' ? 'selected' : '' }}>12GB</option>
                            </select>
                            <select name="variants[{{ $index }}][rom]" required
                                class="mt-1 block w-full px-10 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="">Chọn ROM</option>
                                <option value="64GB" {{ old('variants.'.$index.'.rom', $variant->rom) == '64GB' ? 'selected' : '' }}>64GB</option>
                                <option value="128GB" {{ old('variants.'.$index.'.rom', $variant->rom) == '128GB' ? 'selected' : '' }}>128GB</option>
                                <option value="256GB" {{ old('variants.'.$index.'.rom', $variant->rom) == '256GB' ? 'selected' : '' }}>256GB</option>
                                <option value="512GB" {{ old('variants.'.$index.'.rom', $variant->rom) == '512GB' ? 'selected' : '' }}>512GB</option>
                            </select>

                            <input type="number" name="variants[{{ $index }}][price]" placeholder="Giá" required
                                value="{{ old('variants.'.$index.'.price', $variant->price) }}"
                                class="mt-1 block w-full px-10 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <input type="number" name="variants[{{ $index }}][stock]" placeholder="Số lượng" required
                                value="{{ old('variants.'.$index.'.stock', $variant->stock) }}"
                                class="mt-1 block w-24 px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>

                        <div class="flex flex-col w-full space-y-2 color-options-container">
                            <label class="block text-sm font-medium text-gray-700">Chọn màu sắc</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="variants[${index}][color][]" value="trắng"
                                        class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Trắng</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="variants[${index}][color][]" value="đen"
                                        class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Đen</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="variants[${index}][color][]" value="xanh"
                                        class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Xanh</span>
                                </label>
                            </div>
                        </div>
                        <button type="button" onclick="addColorOption(this)" class="mt-1 bg-blue-500 text-white px-2 py-3 rounded-md" style="white-space: nowrap">Thêm màu</button>

                    </div>
                @endforeach
            <button type="button" id="addVariant" class="bg-blue-500 text-white px-3 py-2 rounded-md">Thêm biến thể</button>
            </div>
        </div>

        <button type="submit" class="w-full py-2 px-4 bg-blue-500 text-white rounded-md">Cập nhật sản phẩm</button>
    </form>
</div>

<script>
    document.getElementById('addVariant').addEventListener('click', function() {
            const variantGroup = document.querySelector('.variant-group');
            const index = variantGroup.querySelectorAll('.flex').length;

            const variantHTML = `
                <div class="flex items-center justify-between mb-4 border p-4 rounded-md shadow-sm">
                    <div class="flex space-x-4">
                        <select name="variants[${index}][ram]" required
                            class="mt-1 block w-full px-10 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Chọn RAM</option>
                            <option value="4GB">4GB</option>
                            <option value="6GB">6GB</option>
                            <option value="8GB">8GB</option>
                            <option value="12GB">12GB</option>
                        </select>
                        <select name="variants[${index}][rom]" required
                            class="mt-1 block w-full px-10 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Chọn ROM</option>
                            <option value="64GB">64GB</option>
                            <option value="128GB">128GB</option>
                            <option value="256GB">256GB</option>
                            <option value="512GB">512GB</option>
                        </select>

                        <input type="number" name="variants[${index}][price]" placeholder="Giá" required
                            class="mt-1 block w-full px-10 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <input type="number" name="variants[${index}][stock]" placeholder="Số lượng" required
                            class="mt-1 block w-24 px-3 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">

                        <div class="flex flex-col w-full space-y-2 color-options-container">
                            <label class="block text-sm font-medium text-gray-700">Chọn màu sắc</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="variants[${index}][color][]" value="trắng"
                                        class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Trắng</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="variants[${index}][color][]" value="đen"
                                        class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Đen</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="variants[${index}][color][]" value="xanh"
                                        class="form-checkbox h-5 w-5 text-blue-600">
                                    <span class="ml-2 text-gray-700">Xanh</span>
                                </label>
                            </div>
                        </div>

                        <button type="button" onclick="addColorOption(this)" class="mt-1 bg-blue-500 text-white px-2 py-3 rounded-md" style="white-space: nowrap">Thêm màu</button>
                    </div>
                    <button
                        type="button"
                        class="remove-variant bg-red-500 text-white p-3 rounded-md hover:bg-red-600 focus:outline-none"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            `;

            variantGroup.insertAdjacentHTML('beforeend', variantHTML);
        });

        document.querySelector('.variant-group').addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-variant')) {
                event.target.closest('.flex').remove();
            }
        });

        function addColorOption(button) {
            const colorContainer = button.previousElementSibling.querySelector('.flex');

            const newColorContainer = document.createElement('div');
            newColorContainer.className = 'flex flex-wrap mt-2';

            const colors = ['Đỏ', 'Vàng', 'Tím'];
            colors.forEach(color => {
                const label = document.createElement('label');
                label.className = 'inline-flex items-center';

                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = button.parentElement.querySelector('select').name.replace(/\[\d+\]/, `[${getCurrentIndex(button)}]`) + '[color][]';
                checkbox.value = color;
                checkbox.className = 'form-checkbox h-5 w-5 text-blue-600';

                const span = document.createElement('span');
                span.className = 'ml-2 text-gray-700';
                span.textContent = color;

                label.appendChild(checkbox);
                label.appendChild(span);
                newColorContainer.appendChild(label);
            });

            colorContainer.appendChild(newColorContainer);
        }

        function getCurrentIndex(button) {
            const variant = button.closest('.flex');
            const allVariants = document.querySelectorAll('.variant-group .flex');
            return Array.from(allVariants).indexOf(variant);
        }
    function removeVariant(button) {
        button.closest('.variant-group').remove();
    }
</script>
@endsection
