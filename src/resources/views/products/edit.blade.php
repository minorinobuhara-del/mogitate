@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <img src="{{ asset('storage/' . $product->image) }}" class="detail-image">

    <input type="file" name="image">

    <label>商品名</label>
    <input type="text" name="name" value="{{ old('name', $product->name) }}">

    <label>価格</label>
    <input type="number" name="price" value="{{ old('price', $product->price) }}">

    <label>商品説明</label>
    <textarea name="description">{{ old('description', $product->description) }}</textarea>

    <button type="submit" class="btn-save">変更を保存</button>
</form>
@endsection
