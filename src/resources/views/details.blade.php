@extends('layouts.layouts')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<form id="product-update" class="detail" method="POST" enctype="multipart/form-data" action="{{ route('products.update', $product) }}">
    @csrf
    @method('PATCH')
    <div class="detail__breadcrumb">
        <a href="{{ route('products.index') }}">商品一覧</a>
        <span>＞</span>
        <span>{{ $product->name }}</span>
    </div>

    <div class="detail__body">
        <div class="detail__image">
            @php
                $imagePath = $product->image ?? '';
                if (preg_match('/^https?:\/\//', $imagePath)) {
                    $imageUrl = $imagePath;
                } elseif (!empty($imagePath)) {
                    $imageUrl = str_starts_with($imagePath, 'img/') ? asset($imagePath) : asset('storage/' . ltrim($imagePath, '/'));
                } else {
                    $imageUrl = 'https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=800&q=80';
                }
            @endphp
            <img src="{{ $imageUrl }}" alt="{{ $product->name ?? '商品画像' }}">
            <div class="detail__file">
                <label class="file-label">
                    <input type="file" name="image">
                    ファイルを選択
                </label>
                <span class="file-name">{{ $product->image_name }}</span>
            </div>
            @error('image')
                <p class="error">{{ $message }}</p>
            @enderror
        </div>

        <div class="detail__form">
            <div class="form-group">
                <label for="name">商品名</label>
                <input id="name" type="text" name="name" value="{{ old('name', $product->name ?? 'キウイ') }}">
                @error('name')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">値段</label>
                <input id="price" type="number" name="price" value="{{ old('price', $product->price ?? 800) }}">
                @error('price')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label>季節</label>
                <div class="checks">
                    @php $checkedSeasons = old('season', $selectedSeasons ?? []); @endphp
                    @foreach($seasons as $season)
                        <label class="check">
                            <input type="checkbox" name="season[]" value="{{ $season->id }}" {{ in_array($season->id, $checkedSeasons) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                    @endforeach
                </div>
                @error('season')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="detail__description">
        <p class="description__label">商品説明</p>
        <textarea name="description" rows="4">{{ old('description', $product->description ?? '爽やかな香りと上品な甘みが特徴的なキウイは大人から子どもまで大人気のフルーツです。疲れた脳や体のエネルギー補給にも最適の商品です。もぎたてフルーツのスムージーをお召し上がりください！') }}</textarea>
        @error('description')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

</form>

<div class="detail__footer">
    <div class="detail__actions">
        <a class="btn btn--ghost" href="{{ route('products.index') }}">戻る</a>
        <button type="submit" class="btn btn--primary" form="product-update">変更を保存</button>
    </div>
    <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('削除しますか？');" class="detail__delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn--danger" aria-label="削除">🗑</button>
    </form>
</div>
@endsection
