@extends('admin.main_admin')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">Thêm Sản Phẩm</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Tên sản phẩm -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Tên sản phẩm</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Giá sản phẩm -->
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Giá sản phẩm</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" step="1" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Số lượng sản phẩm -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Số lượng sản phẩm</label>
                <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" step="1" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
            </div>

            <!-- Thương hiệu -->
            <div>
                <label for="brand_id" class="block text-sm font-medium text-gray-700">Thương hiệu</label>
                <select name="brand_id" id="brand_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">Chọn thương hiệu</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
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
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Mô tả sản phẩm -->
            <div class="col-span-2">
                <label for="description" class="block text-sm font-medium text-gray-700">Mô tả sản phẩm</label>
                <textarea name="description" id="description" rows="4" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('description') }}</textarea>
            </div>

            <!-- Hình ảnh sản phẩm -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Hình ảnh sản phẩm</label>
                <input type="file" name="image" id="image"
                    class="mt-1 block w-full text-sm text-gray-700 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Tùy chọn và màu sắc -->
        <div class="variant-group space-y-4 mt-8">
            <div class="border p-4 rounded-md shadow-sm">
                <div class="mb-4">
                    <h3 class="font-semibold text-lg mb-3">Tùy chọn</h3>
                    <div class="flex flex-wrap space-x-4">
                        @foreach($options as $option)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="variants[0][option][]" value="{{ $option->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-700">{{ $option->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="font-semibold text-lg mb-3">Màu sắc</h3>
                    <div class="flex flex-wrap space-x-4">
                        @foreach($colors as $color)
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="variants[0][color][]" value="{{ $color->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                                <span class="ml-2 text-gray-700">{{ $color->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="flex justify-between mt-4">
                    <button type="button" id="addOptionBtn" class="bg-blue-500 text-white px-4 py-2 rounded-md">Thêm Tùy chọn</button>
                    <button type="button" id="addColorBtn" class="bg-blue-500 text-white px-4 py-2 rounded-md">Thêm Màu</button>
                </div>
            </div>
        </div>

        <!-- Submit and Reset Buttons -->
        <div class="flex justify-start mt-6">
            <button type="reset" class="bg-green-500 text-white px-4 py-2 rounded-md ml-2">Hủy bỏ</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Lưu sản phẩm</button>
        </div>
    </form>
</div>


<div id="optionModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 z-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-xl font-semibold mb-4">Thêm Tùy Chọn</h3>

        <!-- Option Name Input -->
        <div class="mb-4">
            <label for="option_name" class="block text-sm font-medium text-gray-700">Nhập tên tùy chọn</label>
            <input name="option_name" id="option_name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Nhập tên tùy chọn">
        </div>

        <!-- Option Price Input -->
        <div class="mb-4">
            <label for="option_price" class="block text-sm font-medium text-gray-700">Nhập giá tiền tùy chọn</label>
            <input name="option_price" id="option_price" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Nhập giá tiền cho tùy chọn">
        </div>

        <!-- Modal Action Buttons -->
        <div class="flex justify-end">
            <button type="button" id="closeOptionModal" class="bg-red-500 text-white px-4 py-2 rounded-md mr-2">Đóng</button>
            <button type="button" onclick="fetchDataOption()" id="saveOptionBtn" class="bg-blue-500 text-white px-4 py-2 rounded-md">Lưu Tùy Chọn</button>
        </div>
    </div>
</div>

<!-- Modal for Adding Color -->
<div id="colorModal" class="hidden fixed inset-0 bg-gray-500 bg-opacity-50 z-50 flex justify-center items-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-xl font-semibold mb-4">Thêm Màu</h3>

        <!-- Color Name Input -->
        <div class="mb-4">
            <label for="color_name" class="block text-sm font-medium text-gray-700">Nhập tên màu</label>
            <input name="color_name" id="color_name" type="text" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Nhập tên màu">
        </div>

        <div class="mb-4">
            <label for="color_price" class="block text-sm font-medium text-gray-700">Nhập giá tiền màu</label>
            <input name="color_price" id="color_price" type="number" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" placeholder="Nhập giá tiền cho màu">
        </div>
        <div class="flex justify-end">
            <button type="button" id="closeColorModal" class="bg-red-500 text-white px-4 py-2 rounded-md mr-2">Đóng</button>
            <button type="button" onclick="fetchDataColor()"  id="saveColorBtn" class="bg-blue-500 text-white px-4 py-2 rounded-md">Lưu Màu</button>
        </div>
    </div>
</div>
<script>
    
    document.addEventListener('DOMContentLoaded', ()=>{

    })

    
    document.getElementById('addOptionBtn').addEventListener('click', function() {
        document.getElementById('optionModal').classList.remove('hidden');
    });
    

    document.getElementById('addColorBtn').addEventListener('click', function() {
        document.getElementById('colorModal').classList.remove('hidden');
    });

    document.getElementById('closeOptionModal').addEventListener('click', function() {
        document.getElementById('optionModal').classList.add('hidden');
    });

    document.getElementById('closeColorModal').addEventListener('click', function() {
        document.getElementById('colorModal').classList.add('hidden');
    });
    
    function fetchDataColor() {
    const colorName = document.getElementById('color_name').value;
    const colorPrice = document.getElementById('color_price').value;

    fetch('/admin/addcolor', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',  
        },
        body: JSON.stringify({
            color_name: colorName,    
            color_price: colorPrice   
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data); 
    })
    .catch((error) => {
        console.error('Error:', error); 
    });
}

function fetchDataOption() {
    const colorName = document.getElementById('option_name').value;
    const colorPrice = document.getElementById('option_price').value;

    fetch('/admin/addoption', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',  
        },
        body: JSON.stringify({
            option_name: colorName,    
            option_price: colorPrice   
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data); 
    })
    .catch((error) => {
        console.error('Error:', error); 
    });
}
</script>
@endsection