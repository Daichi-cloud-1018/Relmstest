@extends('layouts.layouts')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="page">
    <div class="page__header">
        <h1 class="page__title">商品一覧</h1>
        <a class="button button--add" href="{{ route('products.create') }}">＋ 商品を追加</a>
    </div>

    <div class="page__body">
        <aside class="sidebar">
            <div class="search">
                <form method="GET" class="search">
                    <input class="search__input" type="text" name="q" placeholder="商品名で検索" value="{{ $keyword ?? '' }}">
                    <input type="hidden" name="sort" value="{{ $sort ?? 'id' }}">
                    <button class="button button--search">検索</button>
                </form>
            </div>
            <div class="sort">
                <p class="sort__label">価格順で表示</p>
                <form method="GET">
                    <select name="sort" class="sort__select" onchange="this.form.submit()">
                        <option value="id" {{ ($sort ?? 'id') === 'id' ? 'selected' : '' }}>価格で並び替え</option>
                        <option value="price_asc" {{ ($sort ?? '') === 'price_asc' ? 'selected' : '' }}>安い順</option>
                        <option value="price_desc" {{ ($sort ?? '') === 'price_desc' ? 'selected' : '' }}>高い順</option>
                    </select>
                </form>
            </div>
        </aside>

        <section class="products">
            @foreach($products as $product)
            <a class="card-link" href="{{ route('products.detail', $product) }}">
                <article class="card">
                    <div class="card__image">
                        @php
                            $imagePath = $product->image ?? '';
                            if (preg_match('/^https?:\\/\\//', $imagePath)) {
                                $imageUrl = $imagePath;
                            } elseif (!empty($imagePath)) {
                                $imageUrl = str_starts_with($imagePath, 'img/') ? asset($imagePath) : asset('storage/' . ltrim($imagePath, '/'));
                            } else {
                                $imageUrl = 'https://images.unsplash.com/photo-1502741338009-cac2772e18bc?auto=format&fit=crop&w=800&q=80';
                            }
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                    </div>
                    <div class="card__body">
                        <span class="card__name">{{ $product->name }}</span>
                        <span class="card__price">¥{{ $product->price }}</span>
                    </div>
                </article>
            </a>
            @endforeach
        </section>
    </div>

    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator || $products instanceof \Illuminate\Pagination\Paginator)
    <nav class="pagination" aria-label="ページネーション">
        @if ($products->onFirstPage())
        <span class="pagination__control is-disabled" aria-hidden="true">&lt;</span>
        @else
        <a class="pagination__control" href="{{ $products->previousPageUrl() }}" aria-label="前のページ">&lt;</a>
        @endif

        @for ($i = 1; $i <= $products->lastPage(); $i++)
            @if ($i == $products->currentPage())
            <span class="pagination__page is-active">{{ $i }}</span>
            @else
            <a class="pagination__page" href="{{ $products->url($i) }}">{{ $i }}</a>
            @endif
            @endfor

            @if ($products->hasMorePages())
            <a class="pagination__control" href="{{ $products->nextPageUrl() }}" aria-label="次のページ">&gt;</a>
            @else
            <span class="pagination__control is-disabled" aria-hidden="true">&gt;</span>
            @endif
    </nav>
    @endif
</div>
@endsection
