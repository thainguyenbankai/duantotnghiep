<?php

use App\Http\Controllers\AddressController;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VNPayController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\WishListController;

Route::post('api/products/{id}/view', [ProductController::class, 'increaseViewCount']);
Route::get('/', [ HomeController::class, 'index'])->name('page.home');
//Comment 
Route::get('/api/comments/{productId}', [CommentController::class, 'comment']);
Route::get('/api/comments/stats/{productId}', [CommentController::class, 'comment_stats']);
Route::post('/api/comments', [CommentController::class, 'add_comment']);
// Địa chỉ
Route::get('/api/address', [AddressController::class, 'address' ]);
Route::put('/api/address/{addressid}', [AddressController::class, 'put_address']);
Route::post('/api/address', [AddressController::class, 'add_address']);
// Đơn hàng
Route::post('/api/order', [OrderController::class, 'store']);
Route::post('/api/orders', [OrderController::class, 'store_bank']);
Route::get('/OrderHistory', function () {
    return Inertia::render('OrderHistory');
})->name('order.history');
Route::delete('/api/orders/{id}', [OrderController::class, 'destroy']);
Route::get('/api/orders/history', [OrderController::class, 'show_history'])->name('orders.history');
// Tìm kiếm
Route::get('/api/search', [HomeController::class, 'search'])->name('search');
Route::get('/search-results',[HomeController::class, 'search_results']);
// Hiển thị sản phẩm theo danh mục
Route::get('/categories/{id?}', [CategoryController::class, 'show_categories'])->name('categories.show');
Route::get('/list/category', function () {
    $categories = Category::all();
    return response()->json(['categories' => $categories], 200);
})->name('categories.list');
// Thanh toán vnpay
Route::post('/vnpay/create-payment-link', [VNPayController::class, 'createPaymentLink']);
Route::post('/vnpay/callback', [VNPayController::class, 'callback'])->name('vnpay.callback');
Route::get('/vnpay/return', [VNPayController::class, 'vnpay_return'])->name('vnpay.return');
Route::post('/api/vnpay', [VNPayController::class, 'vnpay_store']);
// Sản phẩm
Route::get('/products', [ProductController::class, 'products'])->name('page.products');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
//Sản phẩm yêu thích
Route::get('/wishlist', [WishListController::class, 'get_wishlists'])->name('wishlist');
Route::post('/api/favorites', [ WishListController::class, 'add_wishlist']);
Route::delete('api/favorites/{productID}', [WishListController::class,'delete_wishlist']);
// giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/products', [CartController::class, 'store']);
Route::post('/api/cart/quantity',[CartController::class, 'quantity']);
Route::post('/api/cart/add', [CartController::class, 'add_cart'] );
Route::post('/api/cart/remove', [CartController::class, 'remove_cart']);
Route::get('/api/count/cart', [CartController::class, 'count_cart']);
// Xác thực email
Route::get('/show-verify', function () {
    return Inertia::render('Auth/VerifyForm');
})->name('verify.form');
Route::post('/verify', [VerificationController::class, 'verify'])->name('auth.verify');
Route::post('api/send-warranty-support', [MailController::class, 'sendWarrantySupportEmail']);
Route::get('/newpassword',fn() =>
    Inertia::render('Auth/ResetPassword')
)->name('auth.newpassword');
Route::post('/api/newpassword', [ PasswordController::class, 'NewPass'])->name('new.password');
Route::get('verify-email/{token?}/{email?}', function ($token = null, $email = null) {
    $user = User::where('email', $email)->where('verification_code', $token)->first();

    if (!$user) {
        return Inertia::render('Auth/Login', ['error' => 'Email hoặc mã xác minh không hợp lệ.']);
    }

    if ($user->email_verified_at !== null) {
        return Inertia::render('Auth/Login', ['error' => 'Tài khoản đã được xác minh rồi.']);
    }

    $user->email_verified_at = now();
    $user->verification_code = null;  // Xóa mã xác minh sau khi xác nhận
    $user->save();

    return Inertia::render('Auth/Login', [
        'success' => 'Xác minh thành công. Vui lòng đăng nhập.',
    ]);
});

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
Route::post('api/user/update', function (Request $request) {
    $user = User::find($request->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->status = $request->status;
    $user->save();
    return response()->json(['message' => 'Cập nhất thành công'], 200);
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/products/show', [ProductController::class, 'show']);
Route::prefix('admin')->name('admin.')->middleware(['admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('index');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');

    Route::resource('colors', ColorController::class);
    Route::get('colors/{id}/restore', [ColorController::class, 'restore_colors'])->name('colors.restore');
    Route::delete('colors/{id}/force-delete', [ColorController::class, 'force_delete_colors'])->name('colors.force_delete');
    Route::get('/trash_colors', [ColorController::class, 'trash_colors'])->name('trash_colors');
    Route::resource('options', OptionController::class);
    Route::get('options/{id}/restore', [OptionController::class, 'restore'])->name('options.restore');
    Route::delete('options/{id}/force-delete', [OptionController::class, 'delete'])->name('options.force_delete');
    Route::get('/trash_options', [OptionController::class, 'trash_option'])->name('trash_options');


    Route::resource('users', AdminController::class);
    Route::put('users/{id}/update-status', [AdminController::class, 'updateStatus'])->name('users.updateStatus');

    Route::get('/categories', [AdminController::class, 'rec_category'])->name('categories');
    Route::get('/categories/trash-category', [CategoryController::class, 'trash_category'])->name('trash_categories');
    Route::resource('categories', CategoryController::class);

    Route::get('/products', [AdminController::class, 'rec_product'])->name('products');
    Route::resource('products', ProductController::class);
    Route::get('products/{id}/restore', [ProductController::class, 'restore_product'])->name('products.restore');
    Route::delete('products/{id}/force-delete', [ProductController::class, 'force_delete_product'])->name('products.force_delete');
    Route::get('/trash_product', [ProductController::class, 'trash_product'])->name('trash_product');

    Route::get('/orders', [AdminController::class, 'rec_order'])->name('orders');
    Route::get('/orders/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/payment/', [OrderController::class, 'paymentsIndex'])->name('payments.index');
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
