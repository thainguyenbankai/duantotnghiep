<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WishListController extends Controller
{
    public function add_wishlist(Request $request) {
        $user = Auth::user();
    if ($user) {
        $product_id = $request->productId;

        $existingWishList = Favorites::where('user_id', $user->id)
            ->where('product_id', $product_id)
            ->first();
        if ($existingWishList) {
            return response()->json(['message' => 'Sản phẩm đã có trong danh sách yêu thích'], 400);
        }
        Favorites::create([
            'user_id' => $user->id,
            'product_id' => $product_id,
        ]);

        return response()->json(['message' => 'Sản phẩm đã được thêm vào danh sách yêu thích'], 200);
    }
    return response()->json(['message' => 'Vui lòng đăng nhập để tiếp tục'], 401);
    }

    public function delete_wishlist(string $productId) {
        $user = Auth::user();
    $favorite = Favorites::where('user_id', $user->id)
        ->where('product_id', $productId)
        ->first();
    if (!$favorite) {
        return response()->json(['message' => 'Không tìm thấy sản phẩm trong danh sách yêu thích.'], 404);
    }
    $favorite->delete();
    return response()->json(['message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích.'], 200);
    }

    public function get_wishlists() {
        $user_id = Auth::id();
    if ($user_id) {
        $wishlists = Favorites::with('product')->where('user_id', $user_id)->get();

        return Inertia::render('Wishlist', ['wishlists' => $wishlists]);
    } else {
        return redirect()->route('login');
    }
    }
}
