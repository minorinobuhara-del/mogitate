@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="page-title">商品一覧</h2>

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
                    <option value="asc" {{ request('sort')=='asc' ? 'selected' : '' }}>
                        安い順
                    </option>
                    <option value="desc" {{ request('sort')=='desc' ? 'selected' : '' }}>
                        高い順
                    </option>
                </select>
            </form>
        </aside>

        <!-- 商品一覧 -->
        <div class="product-grid">
            @forelse ($products as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}">
                    <div class="product-info">
                        <p class="product-name">{{ $product->name }}</p>
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
