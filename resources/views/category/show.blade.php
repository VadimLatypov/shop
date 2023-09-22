@extends('layout.main')

@section('page-title')
{{ $title }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    <div class="row my-5">
        <div class="col-md-7 order-md-2">
            <h2 class="text-center">{{ $product->title }}</h2>
            <p class="lead">{{ $product->anons }}</p>
            <div class="d-flex">
                <h3 class="me-5">{{ $product->price }} ₽</h3>
                <form>
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $product->id }}">
                    <button type="button" class="btn btn-outline-dark" onclick="addBasket({{ $product->id }})">В корзину</button>
                </form>
            </div>
            <div class="my-5">
                <h3>О товаре</h3>
                <p>{{ $product->text }}</p>
            </div>
        </div>
        <div class="col-md-5 order-md-1">
            <img src="{{ asset('img/products/' . $product->img_main) }}" alt="Изображение товара" class="w-75">
        </div>
    </div>
    <div class="reviews mb-5">
        <h3>Отзывы</h3>
        @if (count($reviews) > 0)
            @foreach ($reviews as $el)
                <div class="one_review alert mt-3 d-flex justify-content-between align-items-top">
                    <div>
                        <h6><b>{{ $el->user->name }}</b> <span>пишет:</span></h6>
                        <p class="mb-0">{{ $el->text }}</p>
                    </div>

                    {{-- Кнопка по удалению своего отзыва --}}
                    @auth
                        @if(Auth::user()->id == $el->user_id)
                            <form action="/review/delete/{{ $el->id }}" method="get" class="del-item">
                                @csrf
                                <input type="hidden" name="del_item" value="{{ $el->id }}">
                                <button type="submit" class="btn" title="Удалить отзыв"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        @endif
                    @endauth
                </div>
            @endforeach
        @else
            <p class="no_reviews">Отзывов к этому товару пока нет.</p>
        @endif

        {{-- Добавить отзыв --}}
        @guest
            <div class="row text-center m-auto col-xs-10 col-sm-8 col-md-7 col-lg-6 col-xxl-4">
                <a href="/login" class="btn btn-success mb-4">Авторизуйтесь, чтобы оставлять отзывы</a>
            </div>
        @else
            <form action="/product/{{ $product->id }}/review-add" method="POST" class="review-form form-control mt-5">
                @csrf

                <label for="review"><h4>Оставьте свой отзыв</h4></label>
                <textarea class="form-control form-control-plaintext px-2" name="review" id="review" placeholder="Напишите здесь"></textarea>

                <button type="submit" class="btn btn-success my-2">Добавить</button>
            </form>
        @endguest
    </div>
@endsection