@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">

@section('content')

<div class="product-detail-page">

    <nav class="breadcrumb">
    <a href="{{ route('products.index') }}">商品一覧</a> > {{ $product->name }}
    </nav>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="product-top">
    <div class="image-area">
        <img src="{{ asset('storage/' . $product->image) }}" class="detail-image">
        <input type="file" name="image">
    </div>

    <div class="form-area">
        <label>商品名</label>
        <input type="text" name="name" value="{{ old('name', $product->name) }}">

        <label>値段</label>
        <input type="number" name="price" value="{{ old('price', $product->price) }}">

        <label>季節</label>
        <div class="season">
    @foreach ($seasons as $season)
            <label>
            <input type="checkbox" name="season[]" value="{{ $season->id }}"
                {{ $product->seasons->contains($season->id) ? 'checked' : '' }}>
            {{ $season->name }}
            </label>
        @endforeach
        </div>

        @error('season')
        <p class="error">{{ $message }}</p>
        @enderror
    </div>
    </div>

    <label>商品説明</label>
    <textarea name="description">{{ old('description', $product->description) }}</textarea>

    <div class="buttons">
    <a href="{{ route('products.index') }}" class="back">戻る</a>
    <form action="{{ route('products.update', $product->id) }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <button type="submit" class="btn-save">変更を保存</button>
    </form>
    <form action="{{ route('products.destroy', $product->id) }}"
        method="POST"
        onsubmit="return confirm('この商品を削除しますか？');"
        style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="product-delete-btn">🗑</button>
    </form>
    </div>

</form>
</div>

@endsection
