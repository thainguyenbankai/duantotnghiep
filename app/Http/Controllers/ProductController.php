<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Colors;
use App\Models\Options;
use App\Models\Product;
use App\Models\Category;
use App\Models\Discount;
use App\Models\ProductType;
use Illuminate\Http\Request;
use App\Models\ProductOptions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // HomeController hoặc controller của bạn


    public function index()
    {
        $products = Product::orderBy('id', 'DESC')->paginate(10);
        return view('admin.Product.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::all();
        $categories = Category::all();
        $discounts = Discount::all();
        $types = ProductType::all();
        $options = Options::all();
        $colors = Colors::all();
        return view('admin.Product.create', compact('brands', 'categories', 'discounts', 'types', 'options', 'colors'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:product_types,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('images', 'public');
        }

        $optionsArray = [];
        $colorsArray = [];

        if (isset($request->variants)) {
            foreach ($request->variants as $index => $value) {
                if (!empty($value['option']) && is_array($value['option'])) {
                    foreach ($value['option'] as $option) {
                        $optionsArray[] = (int) $option;
                    }
                }
                if (!empty($value['color']) && is_array($value['color'])) {
                    foreach ($value['color'] as $color) {
                        $colorsArray[] = (int) $color;
                    }
                }
            }
        }

        $validatedData['options_id'] = json_encode($optionsArray);
        $validatedData['colors_id'] = json_encode($colorsArray);


        $product = Product::create($validatedData);

        return redirect()->route('admin.products.index')->with('success', 'Thêm sản phẩm thành công.');
    }




    public function edit($id)
    {
        $product = Product::with('options')->find($id);
        if (!$product) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found.');
        }

        $brands = Brand::all();
        $types = ProductType::all();
        $categories = Category::all();

        return view('admin.Product.edit', compact('product', 'brands', 'types', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'brand_id' => 'required|exists:brands,id',
            'category_id' => 'required|exists:categories,id',
            'type_id' => 'required|exists:product_types,id',
            'image' => 'nullable|image|max:2048',
            'variants' => 'required|array',
            'variants.*.ram' => 'required|string',
            'variants.*.rom' => 'required|string',
            'variants.*.color' => 'required|array',
            'variants.*.price' => 'required|numeric',
            'variants.*.stock' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        $product->update($data);

        $variantIds = collect($request->input('variants'))->pluck('id')->filter();

        $product->options()->whereNotIn('id', $variantIds)->delete();

        foreach ($request->input('variants') as $variant) {
            if (isset($variant['id'])) {
                $optionModel = ProductOptions::find($variant['id']);
                if ($optionModel) {
                    $optionModel->update($variant);
                }
            } else {
                ProductOptions::create(array_merge($variant, ['product_id' => $product->id]));
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $optionsIds = json_decode($product->options_id);
        if (!empty($optionsIds)) {
            Options::whereIn('id', $optionsIds)->delete();
        }
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        // $product->options()->delete();

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
}
