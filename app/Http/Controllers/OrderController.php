<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use App\Models\OrderUser;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = OrderUser::query();

        if ($request->has('order_id') && $request->order_id != '') {
            $query->where('id', 'like', '%' . $request->order_id . '%');
        }

        $orders = $query->get();
        $statuses = OrderStatus::all(); // Assuming you have an OrderStatus model

        return view('admin.Order.index', compact('orders', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $user = OrderUser::findOrFail($id);

        if ($user->status_id == 3) {
            return redirect()->route('admin.orders.index')->with('error', 'Không thể thay đổi trạng thái đơn hàng đã giao thành công.');
        }
        $user->status_id = $request->input('status_id');
        $user->save();

        return redirect()->route('admin.orders.index')->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }


    public function paymentsIndex()
    {
        $payments = Payment::all();
        $orders = OrderUser::with('products')->paginate(10); // Thay 'products' bằng quan hệ phù hợp
        $statuses = OrderStatus::all(); // Nếu bạn sử dụng trạng thái đơn hàng
        return view('admin.Orders.index', compact('orders', 'statuses', 'payments'));
    }

    public function store(Request $request) {
        $address = $request->input('address');
    $cart = $request->input('cart');
    $paymentMethod = $request->input('paymentMethod');
    $totalAmount = $request->input('totalAmount');
    $orderCode = $request->input('orderCode');

    try {
        $order = OrderUser::create([
            'user_id' => $address['user_id'],
            'name' => $address['name'],
            'phone' => $address['phone'],
            'street' => $address['street'],
            'payment_method' => $paymentMethod,
            'total_amount' => $totalAmount,
            'status_id' => 1,
            'products' => json_encode($cart),
            'order_code' => $orderCode,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đặt hàng thành công',
            'order' => $order
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Đã xảy ra lỗi khi tạo đơn hàng',
            'error' => $e->getMessage()
        ], 500);
    }
    }

    /**
     * Display the specified resource.
     */
    public function store_bank(Request $request)
    {
        $user_id = Auth::id();
    if (!$user_id) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $orderData = $request->validate([
        'cart' => 'required|array',
        'address' => 'required|array',
        'paymentMethod' => 'required|string',
        'totalAmount' => 'required|numeric',
    ]);

    $order = new OrderUser();
    $order->user_id = $user_id;
    $order->name = $orderData['address']['name'];
    $order->phone = $orderData['address']['phone'];
    $order->street = $orderData['address']['street'];
    $order->payment_method = $orderData['paymentMethod'];
    $order->total_amount = $orderData['totalAmount'];
    $order->status_id = 1;
    $order->order_code = strtoupper(Str::random(10));
    $order->products = json_encode($orderData['cart']);  // Lưu danh sách sản phẩm dưới dạng JSON
    $order->save();
    foreach ($orderData['cart'] as $item) {
        $product = Product::find($item['id']);
        if ($product && $product->quantity >= $item['quantity']) {
            $product->quantity -= $item['quantity'];
            $product->save();
        } else {
            return response()->json([
                'error' => 'Số lượng sản phẩm không đủ cho sản phẩm ID: ' . $item['id']
            ], 400);
        }
    }
    $productIdsInCart = array_column($orderData['cart'], 'id');
    DB::table('product_cart')
        ->where('user_id', $user_id)
        ->whereIn('product_id', $productIdsInCart)
        ->delete();

    if ($orderData['paymentMethod'] === 'bank') {

        $paymentData = [
            'user_id' => $user_id,
            'order_id' => $order->id,
            'order_code' => $order->order_code,
            'amount' => $order->total_amount,
            'payment_method' => 'bank',
            'transaction_id' => Str::random(16),
            'transaction_date' => now(),
            'transaction_status' => 'pending',
            'ip_address' => $request->ip(),
            'note' => 'Thanh toán qua VNPay',
        ];
        DB::table('payments')->insert($paymentData);
    }
    return response()->json($order, 201);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function show_history(){
        $user_id = Auth::id();
    // Lấy tất cả đơn hàng của người dùng
    $orders = OrderUser::with('orderStatus')->where('user_id', $user_id)->get();

    if ($orders->isEmpty()) {
        // Nếu không có đơn hàng nào, trả về lỗi
        return response()->json(['message' => 'Không có đơn hàng nào'], 404);
    }

    // Sử dụng map để thêm tên trạng thái vào mỗi đơn hàng
    $ordersWithStatus = $orders->map(function ($order) {
        // Lấy tên trạng thái từ quan hệ với bảng order_status
        $name_status = $order->orderStatus ? $order->orderStatus->name : 'Chưa có trạng thái';

        return [
            'id' => $order->id,
            'order_code' => $order->order_code,
            'total_amount' => $order->total_amount,
            'payment_method' => $order->payment_method,
            'created_at' => $order->created_at->format('Y-m-d H:i:s'), // Định dạng ngày giờ
            'name_status' => $name_status,
            'products' => json_decode($order->products),
        ];
    });

    // Trả về response JSON chứa danh sách đơn hàng
    return response()->json(['orders' => $ordersWithStatus], 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_id = Auth::id();
        if ($user_id) {
            $order = OrderUser::where('user_id', $user_id)->where('id', $id)->first();
            if ($order) {
                Payment::where('order_id', $id)->delete();
                $order->delete();
                return response()->json(['message' => 'Đơn hàng đã được hủy thành công'], 200);
            } else {
                return response()->json(['error' => 'Đơn hàng không tồn tại hoặc bạn không có quyền hủy đơn hàng này'], 404);
            }
        }
        return response()->json(['error' => 'Unauthorized'], 200);
    }
}
