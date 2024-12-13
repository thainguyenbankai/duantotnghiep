<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Colors;
use App\Models\Options;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = Product::with('colors', 'options');

        if ($search) {
            // Thực hiện tìm kiếm theo tên sản phẩm
            $products = $query->where('name', 'like', "%{$search}%")->paginate(10);
            $request->session()->flash('search', $products->total()); // Lưu kết quả tìm kiếm vào session
        } else {
            $products = $query->paginate(10);
        }

        return view('admin.Product.index', compact('products'));
    }
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $variants = ProductVariant::where('product_id', $id)->get();

        $variantData = $variants->map(function ($variant) {
            $color = Colors::find($variant->color_id);

            $option = Options::find($variant->option_id);

            return [
                'variant_id' => $variant->id,
                'variant_price' => $variant->variant_price,
                'variant_quantity' => $variant->variant_quantity,
                'color' => $color ? [
                    'id' => $color->id,
                    'name' => $color->name,
                ] : null,
                'option' => $option ? [
                    'id' => $option->id,
                    'ram' => $option->ram,
                    'rom' => $option->rom,
                ] : null,
            ];
        });

        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'base_price' => $product->price,
            'dis_price' => $product->dis_price,
            'images' => json_decode($product->images, true) ?? [], // Giải mã hình ảnh
            'variants' => $variantData, // Danh sách variants
        ];

        // Trả về view với Inertia
        return Inertia::render('Details', ['productData' => $productData]);
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $discounts = Discount::all();
        $options = Options::all();
        $colors = Colors::all();
        return view('admin.Product.create', compact('brands', 'categories', 'discounts', 'options', 'colors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|gt:0',
            'dis_price' => 'required|numeric|lt:price', // Giá khuyến mãi phải nhỏ hơn giá gốc
            'quantity' => 'required|integer|min:1',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants' => 'nullable|array',
            'variants.*.color_id' => 'required_with:variants|exists:colors,id',
            'variants.*.option_id' => 'required_with:variants|exists:options,id',
            'variants.*.variant_price' => 'required_with:variants|numeric|gt:0',
            'variants.*.variant_quantity' => 'required_with:variants|integer|min:0',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá phải là số.',
            'price.gt' => 'Giá phải lớn hơn 0.',
            'dis_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc.',
            'quantity.required' => 'Số lượng sản phẩm là bắt buộc.',
            'quantity.min' => 'Số lượng phải lớn hơn hoặc bằng 1.',
            'brand_id.exists' => 'Thương hiệu không hợp lệ.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'images.*.image' => 'Mỗi tệp tải lên phải là hình ảnh.',
            'variants.*.color_id.exists' => 'Màu sắc không hợp lệ.',
            'variants.*.variant_price.gt' => 'Giá của biến thể phải lớn hơn 0.',
        ]);

        // Xử lý ảnh
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/products', 'public');
                $images[] = $path;
            }
        }

        // Lưu sản phẩm chính
        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'dis_price' => $validated['dis_price'],
            'quantity' => $validated['quantity'],
            'brand_id' => $validated['brand_id'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'images' => json_encode($images),
        ]);

        // Lưu các biến thể
        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'color_id' => $variant['color_id'],
                    'option_id' => $variant['option_id'],
                    'variant_price' => $variant['variant_price'],
                    'variant_quantity' => $variant['variant_quantity'],
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được thêm thành công.');
    }

    public function edit($id)
    {
        $product = Product::with('options', 'colors')->findOrFail($id);

        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Sản phẩm không tồn tại.');
        }
        $product->images = json_decode($product->images, true);
        $brands = Brand::all();
        $categories = Category::all();
        $discounts = Discount::all();
        $options = Options::all();
        $colors = Colors::all();
        return view('admin.Product.edit', compact('product', 'brands', 'categories', 'discounts', 'options', 'colors'));
    }

    public function update(Request $request, string $id)
{
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'description' => 'required',
        'price' => 'required|numeric|gt:0',
        'dis_price' => 'required|numeric|lt:price',
        'quantity' => 'required|integer|min:1',
        'brand_id' => 'required|exists:brands,id',
        'category_id' => 'required|exists:categories,id',
        'status_id' => 'nullable|exists:statuses,id',
        'discount_id' => 'nullable|exists:discounts,id',
        'images' => 'nullable|array|max:5',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'variants' => 'nullable|array',
        'variants.*.color_id' => 'required|exists:colors,id',
        'variants.*.option_id' => 'required|exists:options,id',
        'variants.*.variant_price' => 'required|numeric|gt:0',
        'variants.*.variant_quantity' => 'required|integer|min:0',
    ], [
        'name.required' => 'Tên sản phẩm là bắt buộc.',
        'name.max' => 'Tên sản phẩm không được vượt quá 255 ký tự.',
        'description.required' => 'Mô tả sản phẩm là bắt buộc.',
        'price.required' => 'Giá sản phẩm là bắt buộc.',
        'price.numeric' => 'Giá sản phẩm phải là số.',
        'price.gt' => 'Giá sản phẩm phải lớn hơn 0.',
        'dis_price.required' => 'Giá khuyến mãi là bắt buộc.',
        'dis_price.numeric' => 'Giá khuyến mãi phải là số.',
        'dis_price.lt' => 'Giá khuyến mãi phải nhỏ hơn giá gốc.',
        'quantity.required' => 'Số lượng sản phẩm là bắt buộc.',
        'quantity.integer' => 'Số lượng sản phẩm phải là số nguyên.',
        'quantity.min' => 'Số lượng sản phẩm phải lớn hơn hoặc bằng 1.',
        'brand_id.required' => 'Thương hiệu là bắt buộc.',
        'brand_id.exists' => 'Thương hiệu không hợp lệ.',
        'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
        'category_id.exists' => 'Danh mục sản phẩm không hợp lệ.',
        'status_id.exists' => 'Trạng thái không hợp lệ.',
        'discount_id.exists' => 'Mã giảm giá không hợp lệ.',
        'images.*.image' => 'Mỗi tệp tải lên phải là hình ảnh.',
        'images.*.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg, gif.',
        'images.*.max' => 'Hình ảnh không được vượt quá 2MB.',
        'variants.*.color_id.exists' => 'Màu sắc không hợp lệ.',
        'variants.*.option_id.exists' => 'Thông số không hợp lệ.',
        'variants.*.variant_price.required' => 'Giá của biến thể là bắt buộc.',
        'variants.*.variant_price.numeric' => 'Giá của biến thể phải là số.',
        'variants.*.variant_price.gt' => 'Giá của biến thể phải lớn hơn 0.',
        'variants.*.variant_quantity.required' => 'Số lượng của biến thể là bắt buộc.',
        'variants.*.variant_quantity.integer' => 'Số lượng của biến thể phải là số nguyên.',
        'variants.*.variant_quantity.min' => 'Số lượng của biến thể phải lớn hơn hoặc bằng 0.',
    ]);
    

    $product = Product::findOrFail($id);

    // Xử lý hình ảnh mới
    $imagePaths = json_decode($product->images, true) ?? []; // Giải mã JSON từ cơ sở dữ liệu

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            // Tạo tên ảnh ngẫu nhiên
            $imageName = Str::random(40) . '.' . $image->getClientOriginalExtension();
    
            // Lưu ảnh vào thư mục 'uploads/products' trong storage
            $image->storeAs('public/uploads/products', $imageName);
    
            // Thêm đường dẫn ảnh mới vào mảng $imagePaths
            $imagePaths[] = 'uploads/products/' . $imageName; // Đảm bảo là đường dẫn tương đối
        }
    }
    
    
    $validatedData['images'] = json_encode($imagePaths);

    $product->update($validatedData);

    if ($request->has('removed_images')) {
        $removedImages = explode(',', rtrim($request->removed_images, ','));

        foreach ($removedImages as $image) {
            if (($key = array_search($image, $imagePaths)) !== false) {
                unset($imagePaths[$key]);
                Storage::delete('public/upload/' . $image);
            }
        }
    }

    // Cập nhật lại trường images trong cơ sở dữ liệu
    $product->images = json_encode(array_values($imagePaths));
    $product->save();

    // Cập nhật variants
    DB::transaction(function () use ($product, $request) {
        // Xóa tất cả các variants hiện tại của sản phẩm
        $product->variants()->delete();

        // Kiểm tra và tạo variants mới nếu có
        if (!empty($request->input('variants'))) {
            $variantsToCreate = [];
            foreach ($request->input('variants') as $variant) {
                $variantsToCreate[] = [
                    'product_id' => $product->id,
                    'color_id' => $variant['color_id'],
                    'option_id' => $variant['option_id'],
                    'variant_price' => $variant['variant_price'],
                    'variant_quantity' => $variant['variant_quantity'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (!empty($variantsToCreate)) {
                ProductVariant::insert($variantsToCreate);
            }
        }
    });

    return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm "' . $product->name . '" thành công.');
}

    
    

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $optionsIds = json_decode($product->option_id);
        
        // Xóa các variants của sản phẩm
        ProductVariant::where('product_id', $product->id)->delete();

        // Xóa các ảnh đã lưu
        if ($product->images && Storage::disk('public')->exists($product->images)) {
            foreach (json_decode($product->images) as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Sản phẩm đã được xóa vào thùng rác.');
    }

    public function trash_product()
    {
        $products = Product::onlyTrashed()->paginate(10);
        return view('admin.Product.trash', compact('products'));
    }

    public function restore_product($id)
    {
        $product = Product::withTrashed()->where('id', $id)->first();

        if (!$product) {
            return redirect()->route('admin.trash_product')->with('error', 'Sản phẩm không tồn tại.');
        }

        $product->restore();
        return redirect()->route('admin.trash_product')->with('success', 'Sản phẩm đã được khôi phục.');
    }

    public function increaseViewCount($id)
    {
        $product = Product::findOrFail($id);

        if ($product) {
            $product->increment('view'); // Tăng giá trị của cột `view` trong database
            return response()->json(['success' => true, 'view' => $product->view]);
        }

        return response()->json(['success' => false, 'message' => 'Sản phẩm tìm thấy'], 404);
    }
}
