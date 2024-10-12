<?php

namespace App\Http\Controllers;

use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::all();
        return view('admin.ProductType.index', compact('productTypes'));
    }

    public function create()
    {
        return view('admin.ProductType.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        $data = $request->all();
        ProductType::create($data);
        return redirect()->route('admin.productTypes.index')->with('success', 'Thêm kiểu sản phẩm thành công .');
    }
    public function edit($id)
    {
        $productType = ProductType::find($id);
        return view('admin.ProductType.edit', compact('productType'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $productType = ProductType::find($id);
        $productType->update($request->all());
        return redirect()->route('admin.productTypes.index')->with('success', 'Product Type updated successfully.');
    }

    public function destroy($id)
    {
        ProductType::destroy($id);
        return redirect()->route('admin.productTypes.index')->with('success', 'Product Type deleted successfully.');
    }
}
