@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
<div class="product-container">
    <h1>商品登録</h1>

    <form action="/products" method="POST" enctype="multipart/form-data">
        @csrf

        <label>商品名 <span class="required">必須</span></label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
        <p class="error">{{ $message }}</p>
        @enderror

        <label>値段 <span class="required">必須</span></label>
        <input type="number" name="price" value="{{ old('price') }}">
        @error('price')
        <p class="error">{{ $message }}</p>
        @enderror

        <label>商品画像 <span class="required">必須</span></label>
        <input type="file" name="image">
        @if (!empty($product->image))
        <img src="{{ asset('storage/' . $product->image) }}" class="preview">
        @endif

        @error('image')
        <p class="error">{{ $message }}</p>
        @enderror

        <label>季節 <span class="required">必須</span></label>
        <div class="season">
            @foreach (['春','夏','秋','冬'] as $season)
                <label>
                    <input type="checkbox" name="season[]" value="{{ $season }}">
                    {{ $season }}
                </label>
            @endforeach

            @error('season')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <label>商品説明 <span class="required">必須</span></label>
        <textarea name="description">{{ old('description') }}</textarea>

        <div class="buttons">
            <a href="{{ route('products.index') }}" class="back">戻る</a>
            <button type="submit" class="submit">登録</button>
            @error('description')
            <p class="error">{{ $message }}</p>
            @enderror
        </div>
    </form>
</div>
@endsection
