<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function rec_user()
    {
        return view('admin.index', compact('users'));
    }
    public function rec_category()
    {
        return view('admin.Category.index');
    }
    public function rec_product()
    {
        return view('admin.Product.index');
    }
    public function rec_order()
    {
        return view('admin.Order.index');
    }
    public function rec_suppliers()
    {
        return view('admin.Supplier.index');
    }
    public function rec_productType()
    {
        return view('admin.ProductType.index');
    }
}
