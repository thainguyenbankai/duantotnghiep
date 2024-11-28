@extends('admin.main_admin')

@section('title', 'Danh sách đơn hàng')

@section('content')
<div class="container-fluid mt-4">
    <h2 class="text-xxl font-bold mb-4 text-center">DANH SÁCH ĐƠN HÀNG</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Mã đơn hàng</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Trạng thái</th>
                    <th>Ngày đặt hàng</th>
                    <th>Số điện thoại</th>
                    <th>Phương thức thanh toán</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    @php
                        $products = json_decode($order->products);  // Decode the products JSON
                    @endphp
                    
                    @foreach($products as $product)
                        <tr class="text-center">
                            <!-- Mã đơn hàng -->
                            <td>{{ $loop->parent->iteration }}</td>

                            <!-- Tên sản phẩm -->
                            <td>{{ $product->name }}</td>

                            <!-- Giá sản phẩm -->
                            <td>{{ number_format($product->price, 2) }} VNĐ</td>

                            <!-- Số lượng -->
                            <td>{{ $product->quantity }}</td>

                            <!-- Trạng thái đơn hàng -->
                            <td>
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status_id" class="form-select" onchange="this.form.submit()">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                </form>
                            </td>

                            <!-- Ngày đặt hàng -->
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>

                            <!-- Số điện thoại -->
                            <td>{{ $order->phone }}</td>

                            <!-- Phương thức thanh toán -->
                            <td>{{ $order->payment_method }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
