@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/product.css') }}">

@section('content')

<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <img src="{{ asset('storage/' . $product->image) }}" class="detail-image">

    <input type="file" name="image">

    <label>商品名</label>
    <input type="text" name="name" value="{{ old('name', $product->name) }}">

    <label>値段</label>
    <input type="number" name="price" value="{{ old('price', $product->price) }}">

    <label>季節</label>

    <div class="season">
    @foreach ($seasons ?? '' as $season)
        <label>
            <input
                type="checkbox"
                name="season[]"
                value="{{ $season->id }}"
                {{ $product->seasons->contains($season->id) ? 'checked' : '' }}
            >
            {{ $season->name }}
        </label>
    @endforeach
    </div>

@error('season')
    <p class="error">{{ $message }}</p>
@enderror

    <label>商品説明</label>
    <textarea name="description">{{ old('description', $product->description) }}</textarea>

    <div class="buttons">
    <a href="{{ route('products.index') }}" class="back">戻る</a>
    <button type="submit" class="btn-save">変更を保存</button>
    </div>
</form>
@endsection
