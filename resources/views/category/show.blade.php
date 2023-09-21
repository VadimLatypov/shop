@extends('layout.main')

@section('page-title')
{{ $title }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    {{-- <p>{{ $product->title }}</p>
    div --}}
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
@endsection