@extends('layout/main')

@section('page-title')
{{ $title }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    {{-- Баннер --}}
    <div class="banner my-5">
        <div class="row p-4 pb-0 pe-lg-0 pt-lg-5 align-items-center rounded-3 border shadow-lg overflow-hidden">
            <div class="col-lg-7 p-3 p-lg-5 pt-lg-3">
                <h1 class="display-4 fw-bold lh-1 text-body-emphasis">Здесь вы найдете лучший декор</h1>
                <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis accusamus laudantium saepe dolores ex, asperiores consequatur, molestias fugiat, alias hic animi molestiae rem. Error commodi dolores temporibus magnam veritatis vero.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                <a href="/category/home" class="btn btn-outline-secondary btn-lg px-4">Выбрать свой</a>
                </div>
            </div>
            <div class="col-lg-5 p-0 overflow-hidden shadow-lg img_holder">
                <img class="rounded-lg-3" src="{{ asset('img/products/декор подушка 2.jpeg') }}">
            </div>
        </div>
    </div>

    <h3 class="fw-bold mb-3">Хиты продаж</h3>
    <div class="card_holder d-flex justify-content-between flex-wrap">
        @foreach ($products as $el)
            <div class="card mb-5">
                <img src="{{ asset('img/products/' . $el->img_main) }}" class="card-img-top">
                <div class="card-body">
                    <div class="w-100 quick_view text-center p-3">
                        <a href="/product/{{ $el->id }}" class="nav-link p-0 text-black">Смотреть подробнее</a>
                    </div>
                    <p class="fw-bold">{{ $el->price }} ₽</p>
                    <h6 class="card-title mb-3">{{ $el->title }}</h6>
                    
                    {{-- <form action="/basket_post" method="POST"> --}}
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