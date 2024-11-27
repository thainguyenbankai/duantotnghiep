@extends('admin.main_admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="container mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-4 text-center">DANH SÁCH ĐƠN HÀNG</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Mã đơn hàng</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tên sản phẩm</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Giá</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Số lượng</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Trạng thái</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Ngày đặt hàng</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Số điện thoại</th>
                    <th class="px-6 py-3 border-b border-gray-200 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Phương thức thanh toán</th>
                </tr>
            </thead>
            <tbody class="text-sm font-medium text-gray-700">
                @foreach($orders as $order)
                    @php
                        $products = json_decode($order->products);  // Decode the products JSON
                    @endphp
                    
                    @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <!-- Display order row number -->
                            <td class="px-6 py-4 border-b border-gray-200">{{ $loop->parent->iteration }}</td>

                            <!-- Display product name -->
                            <td class="px-6 py-4 border-b border-gray-200">{{ $product->name }}</td>

                            <!-- Display product price -->
                            <td class="px-6 py-4 border-b border-gray-200">{{ number_format($product->price, 2) }} VNĐ</td>

                            <!-- Display product quantity -->
                            <td class="px-6 py-4 border-b border-gray-200">{{ $product->quantity }}</td>

                            <!-- Display order status -->
                            <td class="px-6 py-4 border-b border-gray-200">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_id" class="status-select form-select mt-1 block w-full border-gray-300 rounded-md shadow-sm"  onchange="this.form.submit()">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach 
                                    </select>
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                </form>
                            </td>

                            <!-- Display the order creation date -->
                            <td class="px-6 py-4 border-b border-gray-200">{{ $order->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $order->phone }}</td>
                            <td class="px-6 py-4 border-b border-gray-200">{{ $order->payment_method }}</td>
                        </tr>
                    @endforeach
                    
                @endforeach
            </tbody>
        </table>
    </div>
</div>  

@endsection
