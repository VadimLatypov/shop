@extends('layout.main')

@section('page-title')
{{ $subtitle }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    <p class="breadcrumbs mt-1">
        <small>
            @if ($subcategory == '')
                <a href="/">Главная</a> / {{ $title }}
            @else
                <a href="/">Главная</a> / <a href="/category/{{ $category }}">{{ $title }}</a> / {{ $subcategory }}
            @endif
        </small>
    </p>
    <h2 class="my-3">{{ $subtitle }}</h2>
    @if ($subcategory == '')
        <aside class="d-block float-start me-5">
            <ul class="nav flex-column">
                @if ($subtitle == 'Мужчинам')
                    <li class="btn btn-light mb-2"><a href="/category/man/clothes" class="nav-link p-0 text-secondary">Одежда</a></li>
                    <li class="btn btn-light mb-2"><a href="/category/man/shoes" class="nav-link p-0 text-secondary">Обувь</a></li>
                    <li class="btn btn-light mb-2"><a href="/category/man/accessories" class="nav-link p-0 text-secondary">Аксессуары</a></li>
                @endif

                @if ($subtitle == 'Женщинам')
                    <li class="btn btn-light mb-2"><a href="/category/woman/clothes" class="nav-link p-0 text-secondary">Одежда</a></li>
                    <li class="btn btn-light mb-2"><a href="/category/woman/shoes" class="nav-link p-0 text-secondary">Обувь</a></li>
                    <li class="btn btn-light mb-2"><a href="/category/woman/accessories" class="nav-link p-0 text-secondary">Аксессуары</a></li>
                @endif

                @if ($subtitle == 'Для дома')
                    <li class="btn btn-light mb-2"><a href="/category/home/bedroom" class="nav-link p-0 text-secondary">Спальня</a></li>
                    <li class="btn btn-light mb-2"><a href="/category/home/kitchen" class="nav-link p-0 text-secondary">Кухня</a></li>
                    <li class="btn btn-light mb-2"><a href="/category/home/bathroom" class="nav-link p-0 text-secondary">Ванная</a></li>
                @endif
            </ul>
        </aside>
    @endif
    <div class="card_holder d-flex justify-content-between flex-wrap">
        @foreach ($products as $el)
            <div class="card mb-5">
                <img src="{{ asset('img/products/' . $el->img_main) }}" class="card-img-top">
                <div class="card-body">
                    <div class="w-100 quick_view text-center p-3">
                        <a href="/product/{{ $el->id }}" class="nav-link p-0 text-black">Смотреть подробнее</a>
                    </div>
                    <p class="fw-bold">{{ $el->price }} ₽</p>
                    <h6 class="card-title">{{ $el->title }}</h6>

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