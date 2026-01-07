<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Season;
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
        $seasons = Season::all();
        return view('products.create', compact('seasons'));
    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        // season を分離
        $seasonIds = $validated['season'];
        unset($validated['season']);

    // 画像を保存
    if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

    // products テーブルに保存
        $product = Product::create($validated);

        //中間テーブル保存
        $product->seasons()->attach($seasonIds);

    return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    //商品削除
    public function destroy(Product $product)
    {
        // 画像ファイルを削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 中間テーブルは cascadeOnDelete で自動削除される
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', '商品を削除しました');
    }

    //商品詳細表示
    public function show(Product $product)
    {
    return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $seasons = Season::all();
        return view('products.edit', compact('product', 'seasons'));
    }

    //更新処理
    public function update(ProductUpdateRequest $request, Product $product)
    {
    // バリデーション後のデータ取得
    $data = $request->validated();

    // season を分離
    $seasonIds = $data['season'];
    unset($data['season']);

    // 画像がアップロードされた場合のみ更新
    if ($request->hasFile('image')) {
        // 古い画像を削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $path = $request->file('image')->store('products', 'public');
        $data['image'] = $path;
    }

    // 商品情報を更新
    $product->update($data);

    // 中間テーブル更新
    $product->seasons()->sync($seasonIds);

    // 商品一覧ページへリダイレクト
    return redirect()
            ->route('products.index')
            ->with('success', '商品情報を更新しました');
    }
}