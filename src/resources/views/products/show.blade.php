<h2>{{ $product->name }}</h2>

<img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">

<p>価格：¥{{ number_format($product->price) }}</p>

<p>季節：</p>
<ul>
    @foreach ($product->seasons as $season)
        <li>{{ $season->name }}</li>
    @endforeach
</ul>

<p>商品説明：</p>
<p>{{ $product->description }}</p>


<a href="{{ route('products.index') }}">一覧に戻る</a>
