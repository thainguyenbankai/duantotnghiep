<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\SupplierController;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
Route::get('/products', function () {
    // Lấy tất cả sản phẩm từ cơ sở dữ liệu
    $products = Product::all();

    // Trả về view của Inertia cùng với dữ liệu sản phẩm
    return Inertia::render('Product/ProductList', [
        'products' => $products,
    ]);
});
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

    Route::get('/orders', [AdminController::class, 'rec_order'])->name('orders');
    Route::resource('orders', OrderController::class);

    Route::get('/revenues', [RevenueController::class, 'rec_revenue'])->name('revenues');
    Route::resource('revenues', RevenueController::class);

    Route::get('/brands', [BrandController::class, 'rec_brands'])->name('brands');
    Route::resource('brands', BrandController::class);

    Route::get('/suppliers', [SupplierController::class, 'rec_suppliers'])->name('suppliers');
    Route::resource('suppliers', SupplierController::class);

    Route::get('/productTypes', [ProductTypeController::class, 'rec_productType'])->name('productTypes');
    Route::resource('productTypes', ProductTypeController::class);
});

require __DIR__ . '/auth.php';
