@extends('layout/main')

@section('page-title')
{{ $title }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    <div class="banner my-5">
        <div class="d-flex flex-wrap align-items-center rounded-3 border shadow-lg overflow-hidden">
            <div class="col-lg-6 p-3 p-lg-5 pt-lg-3">
                <h1 class="display-4 fw-bold lh-1 text-body-emphasis mb-3">Здесь вы найдете лучший декор</h1>
                <p class="lead">Эти стильные предметы декора станут красивым акцентом в вашем интерьере. Выполненные в современном стиле с использованием натуральных материалов. Они добавят изысканности в вашу обстановку.</p>
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4 mb-lg-3">
                </div>
            </div>
            <div id="myCarousel" class="carousel slide my-3 w-xs-100 col-lg-6 p-0 " data-bs-ride="carousel" data-bs-interval="3000" data-bs-pause="hover">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="0" aria-label="Slide 1" class=""></button>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-label="Slide 2" class=""></button>
                    <button type="button" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-label="Slide 3" class="active" aria-current="true"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item">
                        <img class="rounded-lg-3 w-100" src="{{ asset('/public/img/products/свеча.png') }}">
                        <div class="container">
                            <div class="carousel-caption text-start">
                                <h2>Аромасвечи.</h2>
                                <p class="opacity-75">Эта ароматическая свеча наполняет ваш дом теплым и приятным ароматом, создавая расслабляющую атмосферу и поднимая настроение.</p>
                                <p><a class="btn btn-lg btn-primary" href="/product/9">Смотреть</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item active carousel-item-start">
                        <img class="rounded-lg-3 w-100" src="{{ asset('/public/img/products/декор подушка 2.jpeg') }}">
                        <div class="container">
                            <div class="carousel-caption">
                                <h2>Декоративная подушка.</h2>
                                <p>Эта декоративная подушка станет ярким акцентом в вашем интерьере, создавая уют и комфорт и добавляя индивидуальности к вашему дому.</p>
                                <p><a class="btn btn-primary" href="/product/7">Узнать больше</a></p>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item carousel-item-next carousel-item-start">
                        <img class="rounded-lg-3 w-100" src="{{ asset('/public/img/products/диффузор.jpeg') }}">
                        <div class="container">
                            <div class="carousel-caption text-end">
                                <h2>Диффузор с ароматическим маслом.</h2>
                                <p>Этот стильный диффузор с ароматическими маслами помогает создать уютную атмосферу в вашем доме, наполняя его нежными и приятными ароматами.</p>
                                <p><a class="btn btn-lg btn-primary" href="/product/1">Подробнее</a></p>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <h3 class="fw-bold mb-3">Хиты продаж</h3>
    <div class="card_holder d-flex justify-content-between flex-wrap">
        @foreach ($products as $el)
            <div class="card mb-5">
                <img src="{{ asset('/public/img/products/' . $el->img_main) }}" class="card-img-top">
                <div class="card-body">
                    <a href="/product/{{ $el->id }}" class="d-block w-100 quick_view text-center p-3 nav-link text-black">Смотреть подробнее</a>
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