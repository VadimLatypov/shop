@extends('layout.main')

@section('page-title')
{{ $subtitle }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    {{-- Хлебные крошки --}}
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
    <div class="category">
        {{-- Навигация внутри категории --}}
        @if ($subcategory == '')
            <aside class="d-block float-start me-5">
                <ul class="nav flex-column">
                    @if ($subtitle == 'Мужчинам')
                        <li><a href="/category/man/clothes" class="btn btn-light mb-2 nav-link py-2 text-secondary">Одежда</a></li>
                        <li><a href="/category/man/shoes" class="btn btn-light mb-2 nav-link py-2 text-secondary">Обувь</a></li>
                        <li><a href="/category/man/accessories" class="btn btn-light mb-2 nav-link py-2 text-secondary">Аксессуары</a></li>
                    @endif

                    @if ($subtitle == 'Женщинам')
                        <li><a href="/category/woman/clothes" class="btn btn-light mb-2 nav-link py-2 text-secondary">Одежда</a></li>
                        <li><a href="/category/woman/shoes" class="btn btn-light mb-2 nav-link py-2 text-secondary">Обувь</a></li>
                        <li><a href="/category/woman/accessories" class="btn btn-light mb-2 nav-link py-2 text-secondary">Аксессуары</a></li>
                    @endif

                    @if ($subtitle == 'Для дома')
                        <li><a href="/category/home/bedroom" class="btn btn-light mb-2 nav-link py-2 text-secondary">Спальня</a></li>
                        <li><a href="/category/home/kitchen" class="btn btn-light mb-2 nav-link py-2 text-secondary">Кухня</a></li>
                        <li><a href="/category/home/bathroom" class="btn btn-light mb-2 nav-link py-2 text-secondary">Ванная</a></li>
                    @endif
                </ul>
            </aside>
        @endif
        <div class="card_holder d-flex justify-content-between flex-wrap">
            @foreach ($products as $el)
                {{-- Карточка товара --}}
                <div class="card mb-5">
                    <img src="{{ asset('/public/img/products/' . $el->img_main) }}" class="card-img-top">
                    <div class="card-body">
                        <a href="/product/{{ $el->id }}" class="d-block w-100 quick_view text-center p-3 nav-link text-black">Смотреть подробнее</a>
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
    </div>
@endsection