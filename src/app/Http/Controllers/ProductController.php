<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // 商品名検索
        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // 価格順並び替え
        if ($request->sort === 'desc') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'asc') {
            $query->orderBy('price', 'asc');
        }

        $products = $query->paginate(6);

        return view('products.index', compact('products'));
    }
}
