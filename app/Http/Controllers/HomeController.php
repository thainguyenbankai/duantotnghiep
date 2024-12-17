<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(){
        $products = Product::orderBy('id', 'desc')->limit(4)->get();
        $products_news = Product::orderByDesc('id')->get();
        $categorys = Category::orderBy('id', 'desc')->limit(6)->get();
        return Inertia::render('Welcome', [
            'products' => $products,
            'categorys' => $categorys,
            'products_news' => $products_news,
    
        ]);
    }
    public function search(Request $request) {
        $query = $request->input('query');

    if ($query) {
        $results = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();
    } else {
        $results = [];
    }

    return response()->json(['results' => $results]);
    }
    public function search_results(Request $request){
        $query = $request->input('query');
    $results = Product::where('name', 'LIKE', "%{$query}%")->get();
    $count = $results->count();
    return Inertia::render('SearchResults', [
        'results' => $results,
        'query' => $query,
        'count' => $count
    ]);
    }
}
