<?php

use App\Models\User;
use Inertia\Inertia;
use App\Models\Brand;
use App\Models\Colors;
use App\Models\Address;
use App\Models\Options;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Reviews;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\OrderUser;
use App\Models\ProductCart;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProductOptions;
use App\Models\ThumbnailColors;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VNPayController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Auth\VerificationController;


Route::get('/show-verify', function () {
    return Inertia::render('Auth/VerifyForm');
})->name('verify.form');
Route::post('/verify', [VerificationController::class, 'verify'])->name('auth.verify');


Route::get('/newpassword',fn()=>
    Inertia::render('Auth/ResetPassword')
)->name('auth.newpassword');


Route::post('/api/newpassword', function (Request $request) {
    // $validator = Validator::make($request->all(), [
    //     'email' => 'required|email',
    //     'old_password' => 'required|string',
    //     'new_password' => 'required|string|confirmed',
    // ]);

    // if ($validator->fails()) {
    //     return response()->json(['errors' => $validator->errors()], 422);
    // }

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Email không hợp lệ'], 404);
    }

    if (!Hash::check($request->old_password, $user->password)) {
        return response()->json(['message' => 'Mật khẩu cũ không đúng'], 401);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'Đổi mật khẩu thành công']);
})->name('new.password');



Route::get('verify-email/{token?}/{email?}', function ($token = null, $email = null) {
    $encryptedUserData = Cookie::get('user_data');
    if (!$encryptedUserData) {
        return Inertia::render('Auth/Login', ['error' => 'Thông tin người dùng không hợp lệ hoặc đã hết hạn.']);
    }
    
    $userData = decrypt($encryptedUserData);
    if ($userData['email'] !== $email) {
        return Inertia::render('Auth/Login', ['error' => 'Email không hợp lệ.']);
    }

    if ($token !== $userData['verification_code']) {
        return Inertia::render('Auth/Login', ['error' => 'Mã xác minh không đúng.']);
    }

    if (User::where('email', $userData['email'])->exists()) {
        return Inertia::render('Auth/Login', ['error' => 'Email này đã được sử dụng hoặc mã đã hết hạn.']);
    }

    $user = User::create([
        'name' => $userData['name'],
        'email' => $userData['email'],
        'password' => $userData['password'],
        'email_verified_at' => now(),
        'verification_code' => $userData['verification_code'],
    ]);
    return Inertia::render('Auth/Login', [
        'success' => 'Xác minh thành công vui lòng đăng nhập',
    ]);
});




Route::get('/', function () {
    $products = Product::orderBy('id', 'desc')->limit(4)->get();
    $products_news = Product::orderByDesc('id')->get();
    $categorys = Category::orderBy('id', 'desc')->limit(6)->get();
    return Inertia::render('Welcome', [
        'products' => $products,
        'categorys' => $categorys,
        'products_news' => $products_news,

    ]);
})->name('page.home');


Route::get('/paymen/{order_code}', function ($order_code) {
    $orderId = OrderUser::where('order_code', $order_code)->value('id');
    if (!$orderId) {
        abort(404, 'Order not found');
    }
    return Inertia::render('Pay', [
        'orderId' => $orderId
    ]);
})->name('page.paymen');



Route::post('/admin/addoption', function (Request $request) {
    $option = Options::create([
        'name' => $request->option_name,
        'price' => $request->option_price,
    ]);
    return response()->json(["message" => "thêm tùy chọn thành công"], 200);
})->name('admin.options.store');


Route::post('/admin/addcolor', function (Request $request) {
    $option = Colors::create([
        'name' => $request->color_name,
        'price' => $request->color_price,
    ]);
    return response()->json(["message" => "thêm color thành công"], 200);
})->name('admin.colors.store');

Route::post('/api/payment/data', function (Request $request) {
    $orderCode = $request->input('orderCode');
    $existingPayment = Payment::where('order_code', $orderCode)->first();
    if ($existingPayment) {
        return response()->json(['message' => 'Order code already exists, payment data not saved'], 400);
    }
    $paymentData = [
        'order_id' => $request->input('id'),
        'order_code' => $orderCode,
        'noidung' => $request->input('noidung'),
        'money' => $request->input('amount'),
        'status_id' => 0,
    ];
    if (Payment::create($paymentData)) {
        return response()->json(['message' => 'Payment data saved successfully'], 200);
    } else {
        return response()->json(['message' => 'Failed to save payment data'], 500);
    }
});

Route::get('/api/comments/{productId}', function ($productId) {
    $comments = Reviews::with('user')
        ->where('product_id', $productId)
        ->where('status', 1)
        ->orderBy('id', 'desc')
        ->limit(3)
        ->get()
        ->map(function ($comment) {
            return [
                'id' => $comment->id,
                'rating' => $comment->rating,
                'review_text' => $comment->review_text,
                'user_id' => $comment->user_id,
                'username' => $comment->user->name,
            ];
        });
    return response()->json($comments);
});
Route::put('/api/address/{addressid}', function (Request $request, $addressid) {
    $address = Address::find($addressid);

    if (!$address) {
        return response()->json(['message' => 'Địa chỉ không tồn tại.'], 404);
    }

    $address->name = $request->input('name');
    $address->phone = $request->input('phone');
    $address->street = $request->input('street');
    $address->save();

    return response()->json($address, 200);
});

Route::post('/api/address', function (Request $request) {
    $userId = Auth::id();

    if (!$userId) {
        return response()->json(['message' => 'User not authenticated'], 401);
    }

    $address = Address::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'street' => $request->street,
        'user_id' => $userId,
    ]);

    return response()->json($address, 201);
});

Route::get('/api/address', function () {
    $user_id = Auth::id();
    if ($user_id) {
        $addresses = Address::where('user_id', $user_id)->get();
        return response()->json($addresses, 200);
    }
    return response()->json(['error' => 'Unauthorized'], 401);
});

Route::get('/api/comments/stats/{productId}', function ($productId) {
    $ratings = Reviews::select('rating')
        ->where('product_id', $productId)
        ->groupBy('rating')
        ->orderBy('rating', 'desc')
        ->get()
        ->map(function ($review) {
            return [
                'stars' => $review->rating,
                'count' => Reviews::where('rating', $review->rating)

                    ->count(),
            ];
        });

    return response()->json($ratings);
});


Route::post("/api/comments", function (Request $request) {
    $validatedData = $request->validate([
        'rating' => 'required|integer|between:1,5',
        'review_text' => 'required|string|max:500',
        'user_id' => 'required|exists:users,id',
        'product_id' => 'required|exists:products,id',
    ]);
    $comment = Reviews::create([
        'rating' => $validatedData['rating'],
        'review_text' => $validatedData['review_text'],
        'user_id' => $validatedData['user_id'],
        'product_id' => $validatedData['product_id'],
    ]);

    return response()->json([
        'message' => 'Bình luận đã được gửi thành công!',
        'comment' => $comment
    ], 201);
});



Route::post('/api/order', function (Request $request) {
  

    // Extract data
    $address = $request->input('address');
    $cart = $request->input('cart');
    $paymentMethod = $request->input('paymentMethod');
    $totalAmount = $request->input('totalAmount');
    $orderCode = $request->input('orderCode');

    // Create order
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
});

Route::get('/api/search', function (Request $request) {
    $query = $request->input('query');

    if ($query) {
        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();
    } else {
        $results = [];
    }

    return response()->json(['results' => $results]);
})->name('search');


Route::get('/search-results', function (Request $request) {
    $query = $request->input('query');
    $results = Product::where('name', 'LIKE', "%{$query}%")->get();
    $count = $results->count();
    return Inertia::render('SearchResults', [
        'results' => $results,
        'query' => $query,
        'count' => $count
    ]);
});

Route::get('/categories/{id?}', function ($id = null) {
    if ($id) {
        $brand = Brand::with('products')->where('id', $id)->firstOrFail();
        $data = [
            'brand' => $brand,
            'products' => $brand->products,
        ];
    } else {
        $data = [
            'brands' => Brand::with('products')->get(),
            'products' => Product::all(),
        ];
    }
    return Inertia::render('Category', [
        'data' => $data,
    ]);
})->name('categories.show');


Route::get('/OrderHistory', function () {
    $user_id = Auth::id();
    return Inertia::render('OrderHistory');
})->name('order.history');


Route::post('/api/orders', function (Request $request) {
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
    $order->status_id = 1;  // Trạng thái đơn hàng (ví dụ: "Chờ xử lý")
    $order->order_code = strtoupper(Str::random(10));
    $order->products = json_encode($orderData['cart']);  // Lưu danh sách sản phẩm dưới dạng JSON
    $order->save();
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
});
Route::post('/vnpay/create-payment-link', [VNPayController::class, 'createPaymentLink']);
Route::post('/vnpay/callback', [VNPayController::class, 'callback'])->name('vnpay.callback');
Route::get('/vnpay/return', [VNPayController::class, 'return'])->name('vnpay.return');

Route::post('/api/vnpay', function (Request $request) {
    $client = new \GuzzleHttp\Client();
    $response = $client->post('https://sandbox.vnpayment.vn/paymentv2/vpcpay.html', [
        'form_params' => $request->all(),
    ]);
    return response()->json(json_decode($response->getBody(), true));
});



Route::get('/products', function () {
    $products = Product::with(['category:id,name', 'brand:id,name', 'ratings'])->get();
    $products = $products->map(function ($product) {
        $product->average_rating = $product->ratings->avg('rating');
        return $product;
    });
    $categories = Category::select('id', 'name')->get();
    $brands = Brand::select('id', 'name')->get();
    return Inertia::render('AllProduct', [
        'products' => $products,
        'categories' => $categories,
        'brands' => $brands,
    ]);
})->name('page.products');



Route::delete('/api/orders/{id}', function ($id) {
    $user_id = Auth::id();
    if ($user_id) {
        $order = OrderUser::where('user_id', $user_id)->where('id', $id)->first();
        if ($order) {
            $order->delete();
            return response()->json(['message' => 'Đơn hàng đã được hủy thành công'], 200);
        } else {
            return response()->json(['error' => 'Đơn hàng không tồn tại hoặc bạn không có quyền hủy đơn hàng này'], 404);
        }
    }
    return response()->json(['error' => 'Unauthorized'], 401);
});
//vnpay
Route::get('/api/orders/history', function () {
    $user_id = Auth::id();
    if ($user_id) {

        $orders = OrderUser::with('orderStatus')->where('user_id', $user_id)->get();
        return response()->json($orders, 200);
    }
    return response()->json(['error' => 'Unauthorized'], 401);
});

Route::get('/products/{id}', function ($id) {
    $product = Product::findOrFail($id);

    $options_id = [];
    if (is_string($product->options_id)) {
        $decodedOptions = json_decode($product->options_id, true);
        if (is_array($decodedOptions)) {
            $options_id = array_merge($options_id, $decodedOptions);
        }
    }
    $colors_id = [];
    if (is_string($product->colors_id)) {
        $decodedColors = json_decode($product->colors_id, true);
        if (is_array($decodedColors)) {
            $colors_id = array_merge($colors_id, $decodedColors);
        }
    }
    $options = [];
    foreach ($options_id as $option_id) {
        $option = Options::find($option_id);
        if ($option) {
            $options[$option->id] = [
                'name' => $option->name,
                'price' => $option->price,
            ];
        }
    }
    $colors = [];
    foreach ($colors_id as $color_id) {
        $color = Colors::find($color_id);
        if ($color) {
            $colors[$color->id] = [
                'name' => $color->name,
                'price' => $color->price,
            ];
        }
    }
    $productData = [
        'id' => $product->id,
        'name' => $product->name,
        'description' => $product->description,
        'base_price' => $product->price,
        'image' => $product->image,
        'options' => $options,
        'colors' => $colors,
    ];
    return Inertia::render('Details', ['productData' => $productData]);
})->name('products.show');

Route::get('/wishlist',function(){
  $user_id = Auth::id();
  if ($user_id) {
    $wishlists = Wishlist::where('user_id', $user_id)->get();
    return Inertia::render('Wishlist', ['wishlists' => $wishlists]);
  }
})->name('wishlist');

// get thumbnail của color
Route::get('/api/colors/{id}/thumbnail', function ($id) {
    $image = ThumbnailColors::where('color_id', $id)->get();
    return response()->json(array('thumbnail' => $image));
});






Route::get('/list/category', function () {
    $categories = Brand::all();
    return response()->json(['categories' => $categories], 200);
})->name('categories.list');

// Đăng xuất
Route::get('/checkout', function () {
    return Inertia::render('Checkout');
});

// =========About===========
Route::get('/about', function () {
    return Inertia::render('About');
})->name('page.about');

// =========Support===========
Route::get('/support', function () {
    return Inertia::render('Support');
})->name('page.support');
// =========Contact===========
Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('page.contact');

// ====Cart=====
Route::get('/cart', function () {
    $userId = Auth::id();
    $cartItems = ProductCart::with(['product:id,image,name', 'option:id,name'])
        ->where('user_id', $userId)
        ->get()
        ->map(function ($cartItem) {
            return [
                'id' => $cartItem->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->price,
                'product' => $cartItem->product,
                'option_name' => $cartItem->option ? $cartItem->option->name : null,
                'color_name' => $cartItem->color ? $cartItem->color->name : null,
            ];
        });
    return Inertia::render('CartList', [
        'cartItems' => $cartItems
    ]);
})->name('cart');










Route::post('/products', function (Request $request) {
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
});



// ===Cật nhật số lượng====
Route::post('/api/cart/quantity', function (Request $request) {
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
});



Route::post('/api/cart/add', function (Request $request) {
    $product = Product::find($request->id);
    if (!$product) {
        return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
    }
    $optionsJson = json_encode($request->options);
    $price = $request->price;

    $cartItem = ProductCart::where('user_id', Auth::id())
        ->where('product_id', $product->id)
        ->where('options', $optionsJson)
        ->first();

    if ($cartItem) {
        $cartItem->increment('quantity', $request->quantity);
        $cartItem->save();
    } else {
        ProductCart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $price,
            'options' => $optionsJson,
        ]);
    }
    return response()->json(['success' => 'Thêm vào giỏ hàng thành công'], 200);
});


// =======Xóa sản phẩm khỏi giỏ==
Route::post('/api/cart/remove', function (Request $request) {
    $ids = $request->input('ids');
    if ($ids && is_array($ids)) {
        $deletedCount = ProductCart::whereIn('id', $ids)->delete();
        return response()->json(['success' => true, 'message' => 'Xóa sản phẩm thành công'], 200);
    }
    return response()->json(['success' => false, 'message' => 'Xóa sản phẩm thất bại'], 400);
});




Route::post('api/user/update', function (Request $request) {
    $user = User::find($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->status = $request->status;
    $user->save();
    return response()->json(['message' => 'Cập nhất thành công'], 200);
});




Route::get('/api/count/cart', function (Request $request) {
    $userId = Auth::id();
    $cartCount = ProductCart::where('user_id', $userId)->count();
    return response()->json(['count' => $cartCount, "uid" => $userId], 200);
});


// xử lý khi click biến thể
Route::post('api/product_variant', function (Request $request) {});




Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/products/show', [ProductController::class, 'show']);


Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::get('/users', [AdminController::class, 'rec_user'])->name('users');
    Route::resource('users', AdminController::class);

    Route::get('/categories', [AdminController::class, 'rec_category'])->name('categories');
    Route::resource('categories', CategoryController::class);

    Route::get('/products', [AdminController::class, 'rec_product'])->name('products');
    Route::resource('products', ProductController::class);
    Route::get('products/{id}/restore', [ProductController::class, 'restore_product'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [ProductController::class, 'force_delete_product'])->name('products.force_delete');
    Route::get('/trash_product', [ProductController::class, 'trash_product'])->name('trash_product');

    Route::get('/orders', [AdminController::class, 'rec_order'])->name('orders');
    Route::get('/orders/', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{id}/updateStatus', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/brands', [BrandController::class, 'rec_brands'])->name('brands');
    Route::resource('brands', BrandController::class);
    Route::get('brands/{id}/restore', [BrandController::class, 'restore_brand'])->name('restore_brand');

    Route::get('/trash_brand', [BrandController::class, 'trash_brand'])->name('trash_brands');


    Route::resource('reviews', ReviewController::class);
    Route::patch('reviews/{id}/toggle-status', [ReviewController::class, 'toggleStatus'])->name('reviews.toggleStatus');
    Route::get('reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::put('reviews/{id}', [ReviewController::class, 'update'])->name('reviews.update');

    Route::patch('/users/{id}/update-status', [AdminController::class, 'updateStatus'])->name('users.updateStatus');
});

require __DIR__ . '/auth.php';
