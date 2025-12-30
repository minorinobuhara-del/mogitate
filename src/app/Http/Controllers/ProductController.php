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
        if ($request->filled('sort')) {
        if ($request->sort === 'high') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'low') {
            $query->orderBy('price', 'asc');
        }
    }

        $products = $query->paginate(6);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validated();

    // 画像を保存
    if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

    Product::create($validated);

    return redirect('/products/create')->with('success', '商品を登録しました');
    }

    //商品詳細表示
    public function show(Product $product)
{
    return view('products.show', compact('product'));
}


}
