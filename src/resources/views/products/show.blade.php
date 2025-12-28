<h2>{{ $product->name }}</h2>

<img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">

<p>￥{{ $product->price }}</p>
<p>{{ $product->description }}</p>
