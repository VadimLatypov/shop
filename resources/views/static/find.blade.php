@extends('layout/main')

@section('page-title')
{{ $title }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    <h3 class="fw-bold mb-3 mt-5">Товары поиска</h3>
    <div class="card_holder d-flex justify-content-between flex-wrap">
        @foreach ($products as $el)
            <div class="card mb-5">
                <img src="{{ asset('/public/img/products/' . $el->img_main) }}" class="card-img-top">
                <div class="card-body">
                    <div class="w-100 quick_view text-center p-3">
                        <a href="/product/{{ $el->id }}" class="nav-link p-0 text-black">Смотреть подробнее</a>
                    </div>
                    <p class="fw-bold">{{ $el->price }} ₽</p>
                    <h6 class="card-title mb-3">{{ $el->title }}</h6>
                    
                    <form>
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $el->id }}">
                        <button type="button" class="btn btn-outline-dark" onclick="addBasket({{ $el->id }})">В корзину</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
@endsection