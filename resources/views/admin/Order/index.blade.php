@extends('admin.main_admin')
@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">DANH SÁCH ĐƠN HÀNG</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">STT</th>

                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tên sản phẩm</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hình ảnh</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Giá</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Số lượng</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày đặt hàng</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium text-gray-700">
               
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 border-b border-gray-200">3</td>
                    <td class="px-6 py-4 border-b border-gray-200">Sản phẩm </td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <img src="" alt="image_pr" class="w-16 h-16 object-cover">
                    </td>
                    <td class="px-6 py-4 border-b border-gray-200">150,00 VNĐ</td>
                    <td class="px-6 py-4 border-b border-gray-200">5</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <select class="form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="2">Đang xử lý</option>
                            <option value="1">Đang Giao</option>
                            <option value="0">Hoàn thành</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 border-b border-gray-200">03/01/2024</td>
                    <td class="px-6 py-4 border-b border-gray-200">
                        <a href="#" class="text-blue-500 hover:underline">Xem chi tiết</a>
                        {{-- <form action="#" method="POST" class="inline ml-4">
                            <button type="submit" class="text-red-500 hover:underline">Xóa</button>
                        </form> --}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection