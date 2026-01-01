<h2>{{ $product->name }}</h2>

<img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">

<p>価格：¥{{ number_format($product->price) }}</p>
<a href="{{ route('products.index') }}">一覧に戻る</a>