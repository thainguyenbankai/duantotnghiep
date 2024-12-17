<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CartController extends Controller
{
    public function index(){
        $userId = Auth::id();

    $cartItems = ProductCart::with([
        'product' => function ($query) {
            $query->select('id', 'name', 'images');
        },
        'option' => function ($query) {
            $query->select('id', 'ram', 'rom');
        },
        'color' => function ($query) {
            $query->select('id', 'name');
        }
    ])
    ->where('user_id', $userId)
    ->get()
    ->map(function ($cartItem) {
        return [
            'id' => $cartItem->id,
            'product_id' => $cartItem->product_id,
            'quantity' => $cartItem->quantity,
            'price' => $cartItem->price,
            'product' => [
                'id' => $cartItem->product->id,
                'name' => $cartItem->product->name,
                'images' => json_decode($cartItem->product->images, true), // Giả sử ảnh lưu dưới dạng JSON
            ],
            'option_name' => $cartItem->option ? "{$cartItem->option->ram}GB / {$cartItem->option->rom}GB" : null,
            'color_name' => $cartItem->color ? $cartItem->color->name : null,
        ];
    });

    return Inertia::render('CartList', [
        'cartItems' => $cartItems
    ]);
    }
    public function add_cart(Request $request ) {
        if (!Auth::check()) {
            return response()->json(['error' => 'Bạn cần đăng nhập để thêm vào giỏ hàng.'], 401);
        }
    
        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại.'], 404);
        }
    
        $userId = Auth::id();
        $optionId = $request->input('option_id');
        $colorId = $request->input('color_id');
        $quantity = $request->input('quantity', 1);
    
        // Lấy giá sản phẩm (bao gồm giá base + giá option + giá color)
        $basePrice = $product->price;
        $variantPrice = 0;
    
        // Kiểm tra và lấy giá của option nếu có
        if ($optionId && $colorId) {
            $variant = ProductVariant::where('product_id', $product->id)
                ->where('option_id', $optionId)
                ->where('color_id', $colorId)
                ->first();
    
            if ($variant) {
                $variantPrice = $variant->variant_price; // Sử dụng giá variant
            } else {
                $variantPrice = $basePrice; // Nếu không có variant, dùng giá base
            }
        } else {
            $variantPrice = $basePrice; // Nếu không có tùy chọn, dùng giá base
        }
        $totalPrice = ($variantPrice) * $quantity;
    
        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        $cartItem = ProductCart::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->where('option_id', $optionId)
            ->where('color_id', $colorId)
            ->first();
    
        if ($cartItem) {
            // Nếu đã có, cập nhật số lượng và giá
            $cartItem->quantity += $quantity;
            $cartItem->price = $totalPrice;
            $cartItem->save();
        } else {
            // Nếu chưa có, thêm mới vào giỏ hàng
            ProductCart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $totalPrice,
                'option_id' => $optionId,
                'color_id' => $colorId,
            ]);
        }
    
        return response()->json(['success' => 'Sản phẩm đã được thêm vào giỏ hàng.'], 200);
    }

    public function store(Request $request){
        $product = Product::find($request->Product_ID);
    if (!$product) {
        return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
    }

    $ProductOptionID = $request->Option_ID;
    $ProductColorID = $request->Color_ID;
    $ProductQuantity = $request->quantity;
    $ProductTotal = $request->totalPrice;
    $existingCartItem = ProductCart::where('user_id', Auth::id())
        ->where('product_id', $product->id)
        ->first();
    if ($existingCartItem) {
        $matchingItem = ProductCart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('option_id', $ProductOptionID)
            ->where('color_id', $ProductColorID)
            ->first();
        if ($matchingItem) {
            $matchingItem->quantity += $ProductQuantity;
            $matchingItem->save();
        } else {
            ProductCart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $ProductQuantity,
                'price' => $ProductTotal,
                'option_id' => $ProductOptionID,
                'color_id' => $ProductColorID,
            ]);
        }
    } else {
        ProductCart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $ProductQuantity,
            'price' => $ProductTotal,
            'option_id' => $ProductOptionID,
            'color_id' => $ProductColorID,
        ]);
    }
    return response()->json(['success' => 'Thêm vào giỏ hàng thành công'], 200);
    }

    public function quantity(Request $request) {
        $cartItem = ProductCart::find($request->id);
    if ($cartItem) {
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        return response()->json([
            'quantity' => $cartItem->quantity,
        ], 200);
    }
    return response()->json([
        'message' => 'Sản phẩm không tìm thấy.',
    ], 404);
    }

    public function remove(Request $request) {
        $ids = $request->input('ids');
        if ($ids && is_array($ids)) {
            $deletedCount = ProductCart::whereIn('id', $ids)->delete();
            return response()->json(['success' => true, 'message' => 'Xóa sản phẩm thành công'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Xóa sản phẩm thất bại'], 400);
    }
    public function count_cart() {
        $userId = Auth::id();
    $cartCount = ProductCart::where('user_id', $userId)->count();
    return response()->json(['count' => $cartCount, "uid" => $userId], 200);
    }
}
