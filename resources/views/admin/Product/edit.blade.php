@extends('admin.main_admin')

@section('title', 'Chỉnh Sửa Sản Phẩm')

@section('content')
    <style>
        .remove-image-btn {
            font-size: 12px;
            line-height: 1;
            border-radius: 50%;
            color: rgb(12, 11, 11);
            border: none;
        }
    </style>
    <div class="container-fluid my-5">
        <h2 class="text-xxl font-bold mb-4 text-center">SỬA SẢN PHẨM</h2>
        <div class="row mb-3">
            <div class="col-md-6">
                <a href="{{ route('admin.products.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Quay về
                </a>

            </div>
        </div>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Phương thức PUT để cập nhật -->

            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

            <div class="row">
                <!-- Tên sản phẩm -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="control-label">Tên sản phẩm</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}"
                            required class="form-control">
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Số lượng sản phẩm -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="quantity" class="control-label">Số lượng sản phẩm</label>
                        <input type="number" name="quantity" id="quantity"
                            value="{{ old('quantity', $product->quantity) }}" required class="form-control" readonly>
                        @error('quantity')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Giá sản phẩm -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price" class="control-label">Giá sản phẩm</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}"
                            step="0.01" required class="form-control">
                        @error('price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Giá khuyến mãi -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dis_price" class="control-label">Giá khuyến mãi</label>
                        <input type="number" name="dis_price" id="dis_price"
                            value="{{ old('dis_price', $product->dis_price) }}" step="0.01" class="form-control">
                        @error('dis_price')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Thương hiệu -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="brand_id" class="control-label">Thương hiệu</label>
                        <select name="brand_id" id="brand_id" class="form-control">
                            <option value="">Chọn thương hiệu</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Danh mục sản phẩm -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_id" class="control-label">Danh mục sản phẩm</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Mô tả sản phẩm -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="description" class="control-label">Mô tả sản phẩm</label>
                        <textarea name="description" id="description" rows="4" required class="form-control">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Hình ảnh sản phẩm -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="images" class="control-label">Hình ảnh sản phẩm</label>
                        <input type="file" id="fileInput" name="images[]" multiple accept="image/*" class="form-control">
                        @error('images')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div id="preview_images" class="d-flex gap-2 mt-3" style="display: flex">
                        @if (!empty($product->images))
                            @foreach ($product->images as $image)
                                <div class="position-relative">
                                    <img src="{{ asset($image) }}" style="width: 80px; height: 80px;" alt="Ảnh sản phẩm">
                                    <button type="button"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 remove-image-btn"
                                        data-image="{{ $image }}">X</button>
                                </div>
                            @endforeach
                        @else
                            <p>Không có hình ảnh để hiển thị.</p>
                        @endif
                    </div>
                    <input type="hidden" name="removed_images" id="removed_images">
                </div>

                <!-- Tùy chọn và màu sắc -->
                <div id="form-options">
                    @foreach ($product->variants as $variant)
                        <div class="row form-option container-fluid my-5">
                            <input type="hidden" name="variant_id[]" value="{{ $variant->id }}">
                            <!-- Thêm ID vào input ẩn -->
                            <div class="col-md-3">
                                <label for="color">Chọn màu sắc</label>
                                <select name="variants[{{ $variant->id }}][color_id]" class="form-control" required>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}"
                                            {{ $variant->color_id == $color->id ? 'selected' : '' }}>
                                            {{ $color->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="option_id">Thông số</label>
                                <select name="variants[{{ $variant->id }}][option_id]" class="form-control" required>
                                    @foreach ($options as $option)
                                        <option value="{{ $option->id }}"
                                            {{ $variant->option_id == $option->id ? 'selected' : '' }}>
                                            {{ $option->ram }} / {{ $option->rom }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="variant_price">Giá</label>
                                <input type="number" name="variants[{{ $variant->id }}][variant_price]"
                                    class="form-control" value="{{ $variant->variant_price }}" step="0.01">
                            </div>
                            <div class="col-md-3">
                                <label for="variant_quantity">Số lượng</label>
                                <input type="number" name="variants[{{ $variant->id }}][variant_quantity]"
                                    class="form-control" value="{{ $variant->variant_quantity }}" min="1"
                                    id="quantity">
                            </div>
                            <div class="col-md-12 mt-2">
                                <button type="button" class="btn btn-danger btn-sm remove-variant-btn">Xóa</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="form-group container-fluid my-5">
                    <button type="button" id="add-variant-btn" class="btn btn-primary">Thêm tùy chọn</button>
                </div>

                <!-- Submit and Reset Buttons -->
                <div class="form-group container-fluid my-5">
                    <button type="button" id="reset-btn" class="btn btn-danger">Hủy bỏ</button>
                    <button type="submit" class="btn btn-success">Cập nhật sản phẩm</button>
                </div>
        </form>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });

        document.getElementById('fileInput').addEventListener('change', function(event) {
            const previewContainer = document.getElementById('preview_images');
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '80px';
                    img.style.height = '80px';
                    img.style.marginRight = '10px';

                    // Thêm hình ảnh vào preview container
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(files[i]);
            }
        });

        document.querySelectorAll('.remove-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageContainer = this.parentElement;
                const image = this.getAttribute('data-image');
                const removedImages = document.getElementById('removed_images');

                removedImages.value += image + ','; // Lưu các ảnh bị xóa vào input ẩn
                imageContainer.remove(); // Xóa ảnh khỏi giao diện
            });
        });


        let variantCounter = 0;

        document.getElementById('add-variant-btn').addEventListener('click', function() {
            const formOptions = document.getElementById('form-options');
            const newVariantDiv = document.createElement('div');
            newVariantDiv.classList.add('form-option', 'container-fluid', 'my-5');
            newVariantDiv.innerHTML = `
        <div class="row  border  ">
            <div class="col-md-3 ">
                <label for="variants[${variantCounter}][color_id]">Màu sắc</label>
                <select name="variants[${variantCounter}][color_id]" class="form-control" required>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="variants[${variantCounter}][option_id]">Thông số</label>
                <select name="variants[${variantCounter}][option_id]" class="form-control" required>
                    @foreach ($options as $option)
                        <option value="{{ $option->id }}">{{ $option->ram }} / {{ $option->rom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label for="variants[${variantCounter}][variant_price]">Giá</label>
                <input type="number" name="variants[${variantCounter}][variant_price]" class="form-control" step="0.01" required>
            </div>
            <div class="col-md-3">
                <label for="variants[${variantCounter}][variant_quantity]">Số lượng</label>
                <input type="number" name="variants[${variantCounter}][variant_quantity]" class="form-control" step="1" required>
            </div>
            <div class="col-md-12 mt-2">
                <button type="button" class="btn btn-danger btn-sm remove-variant-btn">Xóa</button>
            </div>
        </div>
    `;

            // Đảm bảo rằng khi thêm biến thể mới, giá trị 'selected' được reset
            variantCounter++;
            formOptions.appendChild(newVariantDiv);
        });

        document.querySelectorAll('.remove-image-btn').forEach(button => {
            button.addEventListener('click', function() {
                const imageContainer = this.parentElement;
                const image = this.getAttribute('data-image');
                const removedImages = document.getElementById('removed_images');

                if (removedImages.value.indexOf(image) === -1) {
                    removedImages.value += image + ','; // Lưu các ảnh bị xóa vào input ẩn
                }

                imageContainer.remove(); // Xóa ảnh khỏi giao diện
            });
        });
    </script>
    <script>
        document.getElementById('quantity').addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0; // Ngăn không cho giá trị xuống dưới 0
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceInput = document.getElementById('price');
            const discountPriceInput = document.getElementById('dis_price');
            const totalQuantityInput = document.getElementById('quantity');
            const formOptions = document.getElementById('form-options');
            const price = parseFloat(priceInput.value) || 0;
            const discountPrice = parseFloat(discountPriceInput.value) || price;
            const observer = new MutationObserver(() => updateTotalQuantity());
            observer.observe(formOptions, {
                childList: true
            });


            function updateTotalQuantity() {
                const totalQuantity = Array.from(formOptions.querySelectorAll('input[name$="[variant_quantity]"]'))
                    .reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);
                totalQuantityInput.value = totalQuantity;
            }


            // Kiểm tra giới hạn giá cho các tùy chọn
            formOptions.addEventListener('input', function(event) {
                if (event.target.name?.includes('[variant_price]')) {
                    const price = parseFloat(priceInput.value) || 0;
                    const discountPrice = parseFloat(discountPriceInput.value) || 0;
                    const variantPrice = parseFloat(event.target.value) || 0;

                    if (variantPrice > price || variantPrice > discountPrice) {
                        alert(
                            `Giá của tùy chọn không được vượt quá giá sản phẩm (${price}) hoặc giá khuyến mãi (${discountPrice}).`
                        );
                        event.target.value = ''; // Reset giá trị nếu vượt quá
                    }
                }
            });

            // Tự động cập nhật tổng số lượng khi thay đổi số lượng tùy chọn
            formOptions.addEventListener('input', function(event) {
                if (event.target.name?.includes('[variant_quantity]')) {
                    updateTotalQuantity();
                }
            });

            // Đảm bảo tổng số lượng được cập nhật khi thêm hoặc xóa tùy chọn
            document.getElementById('add-variant-btn').addEventListener('click', updateTotalQuantity);
            formOptions.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-variant-btn')) {
                    setTimeout(updateTotalQuantity, 100); // Đợi DOM cập nhật sau khi xóa
                }
            });

            // Chặn nhập thủ công số lượng tổng
            totalQuantityInput.addEventListener('keydown', function(event) {
                event.preventDefault();
            });
        });
    </script>
@endsection
