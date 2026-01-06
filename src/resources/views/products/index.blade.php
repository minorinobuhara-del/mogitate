@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="page-title">商品一覧</h2>
    <a href="{{ route('products.create') }}" class="add-product-btn">
        + 商品を追加
    </a>

    <div class="product-wrapper">
        <!-- 左サイド -->
        <aside class="sidebar">
            <form method="GET">
                <input
                    type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="商品名で検索"
                    class="search-input"
                >

                <button class="btn-search">検索</button>

                <p class="sort-title">価格順で表示</p>
                <select name="sort" class="sort-select" onchange="this.form.submit()">
                    <option value="">選択してください</option>
                    <option value="high" {{ request('sort')=='high' ? 'selected' : '' }}>
                        安い順
                    </option>
                    <option value="low" {{ request('sort')=='low' ? 'selected' : '' }}>
                        高い順
                    </option>
                </select>
            </form>
        </aside>

        <!-- 商品一覧 -->
        <div class="product-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    <a href="{{ route('products.edit', $product->id) }}">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像"></a>
                    <div class="product-info">
                        <!--商品名-->
                        <p class="product-name">{{ $product->name }}</p>
                        <!--値段-->
                        <p class="product-price">¥{{ number_format($product->price) }}</p>
                    </div>
                </div>
            @empty
                <p>商品がありません</p>
            @endforelse
        </div>
    </div>

    {{ $products->appends(request()->query())->links() }}
</div>
@endsection
