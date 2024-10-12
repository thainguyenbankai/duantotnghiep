<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\discount;
use App\Models\Product;
use App\Models\ProductType;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.Product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $categories = Category::all();
        $discounts = discount::all();
        $types = ProductType::all();
        return view('admin.Product.create', compact('brands', 'suppliers', 'categories', 'discounts', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status_id' => '',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            // 'discount_id' => 'required|exists:discounts,id',
            'type_id' => 'required|exists:product_types,id',
            'supplier_id' => 'required|exists:suppliers,id',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $data['image'] = $imagePath;
        }

        $data['user_id'] = Auth::id();
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Tạo sản phẩm thành công ');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $products = Product::all();
        $j = response()->json($products);
        return view('product/index', compact('products'));
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
