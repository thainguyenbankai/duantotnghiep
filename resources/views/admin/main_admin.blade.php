<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>
</head>
<body class="bg-gray-100">
    <!-- Thanh điều hướng -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-400 p-4 shadow-lg">
        <div class="container mx-auto">
          <div class="flex justify-between items-center">
            <a href="{{ route('admin.index') }}">
                <h1 class="text-white text-3xl font-bold">Admin</h1>
            </a>
            <div class="flex space-x-4">
              <a href="{{ route('admin.users.index') }}" class="text-white hover:text-gray-200">Trang chủ</a>
              <a href="#" class="text-white hover:text-gray-200">Người dùng</a>
              <a href="{{ route('admin.productTypes.index') }}" class="text-white hover:text-gray-200">Kiểu sản phẩm</a>
              <a href="#" class="text-white hover:text-gray-200">Cài đặt</a>
              <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-white hover:text-gray-200">Đăng xuất</button>
              </form>
            </div>
          </div>
          <span class="container mx-auto mt-4 block sm:inline">Xin chào, {{ Auth::user()->name }}!</span>
        </div>
    </nav>

    <!-- Phần hiển thị thông báo -->
    <div class="container mx-auto mt-4">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Thành công!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Xác nhận'
                });
            </script>
        @endif

        @if(session('error'))
            <script>
                Swal.fire({
                    title: 'Lỗi!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'Xác nhận'
                });
            </script>
        @endif
    </div>

    <!-- Phần hiển thị các thẻ -->
    <div class="container mx-auto mt-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('admin.categories.index') }}" class="bg-gradient-to-r from-green-300 to-green-400 p-4 rounded-lg shadow-md hover:scale-105 transform transition duration-300">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center"><i class="fas fa-folder mr-2"></i> Danh mục</h2>
            </a>
            <a href="{{ route('admin.products.index') }}" class="bg-gradient-to-r from-purple-300 to-purple-400 p-4 rounded-lg shadow-md hover:scale-105 transform transition duration-300">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center"><i class="fas fa-box mr-2"></i> Sản phẩm</h2>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="bg-gradient-to-r from-yellow-300 to-yellow-400 p-4 rounded-lg shadow-md hover:scale-105 transform transition duration-300">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center"><i class="fas fa-shopping-cart mr-2"></i> Đơn hàng</h2>
                <p class="mt-2 text-2xl font-bold">567</p>
            </a>
           
            <a href="{{ route('admin.brands.index') }}" class="bg-gradient-to-r from-blue-300 to-blue-400 p-4 rounded-lg shadow-md hover:scale-105 transform transition duration-300">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center"><i class="fas fa-tags mr-2"></i> Thương Hiệu</h2>
            </a>
            <a href="{{ route('admin.reviews.index') }}" class="bg-gradient-to-r from-blue-300 to-blue-400 p-4 rounded-lg shadow-md hover:scale-105 transform transition duration-300">
                <h2 class="text-lg font-semibold text-gray-700 flex items-center"><i class="fas fa-tags mr-2"></i> Bình luận</h2>
                <p class="mt-2 text-xl font-bold">Quản lý bình luận</p>
            </a>
           
            
        </div>

        @yield('content')
        @yield('main')
    </div>
    
    <br>
    <nav class="bg-gradient-to-r from-blue-600 to-blue-400 p-4 shadow-lg">
        <div class="container mx-auto">
            <h1 class="text-white text-center text-xl font-bold">Trương Văn Hiếu - Copyright@2024</h1>
        </div>
    </nav>
</body>
</html>
