<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;

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
        if ($request->sort === 'high') {
            $query->orderBy('price', 'desc');
        } elseif ($request->sort === 'low') {
            $query->orderBy('price', 'asc');
        } else {
            $query->orderBy('id', 'desc'); // デフォルト
        }
        $products = $query->paginate(6)->appends($request->query());

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

    // 画像を保存
    if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

    Product::create($validated);

    return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    //商品詳細表示
    public function show(Product $product)
    {
    return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
    return view('products.edit', compact('product'));
    }

    //更新処理
    public function update(ProductUpdateRequest $request, Product $product)
    {
    // バリデーション後のデータ取得
    $data = $request->validated();

    // 画像がアップロードされた場合のみ更新
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $data['image'] = $path;
    }

    // 季節（配列 → JSON or 配列保存）
    $data['season'] = $request->season;

    // 商品情報を更新
    $product->update($data);

    // 商品一覧ページへリダイレクト
    return redirect()
            ->route('products.index')
            ->with('success', '商品情報を更新しました');
    }
}