<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="Description" content="Главная страница интернет-магазина">
    <meta name="author" content="Вадим Латыпов">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page-title')</title>
    <link rel="shortcut icon" href="{{ asset('/public/img/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('/public/bootstrap_css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/css/app.min.css') }}">
</head>
<body>
    {{-- Шапка --}}
    <header class="p-3 text-bg-dark">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 me-lg-5 text-white text-decoration-none display-6 ">SHOP</a>

                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="/category/man" class="nav-link px-2 text-white">Мужчинам</a></li>
                    <li><a href="/category/woman" class="nav-link px-2 text-white">Женщинам</a></li>
                    <li><a href="/category/home" class="nav-link px-2 text-white">Для дома</a></li>
                </ul>

                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" action="/?подушка" method="get">
                    <input class="form-control form-control-dark text-bg-light" placeholder="Я ищу...">
                </form>

                <div class="text-end">
                    {{-- Authentication Links --}}
                    @guest
                        <a href="/login" class="btn btn-outline-light me-2">Войти</a>
                    @else
                        <a href="/user" class="btn btn-outline-light me-2">{{ Auth::user()->name }}</a>
                    @endguest
                    <a href="/basket" class="btn btn-outline-warning">
                        Корзина <i class="fa-solid fa-cart-shopping"></i>
                        <small class="text-danger" id="basket_count">@yield('basket-count')</small>
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Основная часть --}}
    <main class="container">
        @include('blocks/messages')
        @yield('content')
    </main>

    {{-- Футер --}}
    <div class="text-bg-dark">
        <div class="container pt-3">
            <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 mt-5 border-top">
                <div class="col mb-3">
                    <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 me-5 text-white text-decoration-none h3">SHOP</a>
                    <p class="text-white">© 2023</p>
                </div>
            
                <div class="col mb-3"></div>

                <div class="col mb-3">
                    <h5><a href="/category/man" class="nav-link p-0 text-white">Мужчинам</a></h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="/category/man/clothes" class="nav-link p-0 text-white">Одежда</a></li>
                        <li class="nav-item mb-2"><a href="/category/man/shoes" class="nav-link p-0 text-white">Обувь</a></li>
                        <li class="nav-item mb-2"><a href="/category/man/accessories" class="nav-link p-0 text-white">Аксессуары</a></li>
                    </ul>
                </div>
            
                <div class="col mb-3">
                    <h5><a href="/category/woman" class="nav-link p-0 text-white">Женщинам</a></h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="/category/woman/clothes" class="nav-link p-0 text-white">Одежда</a></li>
                        <li class="nav-item mb-2"><a href="/category/woman/shoes" class="nav-link p-0 text-white">Обувь</a></li>
                        <li class="nav-item mb-2"><a href="/category/woman/accessories" class="nav-link p-0 text-white">Аксессуары</a></li>
                    </ul>
                </div>
            
                <div class="col mb-3">
                    <h5><a href="/category/home" class="nav-link p-0 text-white">Для дома</a></h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="/category/home/bedroom" class="nav-link p-0 text-white">Спальня</a></li>
                        <li class="nav-item mb-2"><a href="/category/home/kitchen" class="nav-link p-0 text-white">Кухня</a></li>
                        <li class="nav-item mb-2"><a href="/category/home/bathroom" class="nav-link p-0 text-white">Ванная</a></li>
                    </ul>
                </div>
            </footer>
        </div>
    </div>
    
    {{-- Сообщение --}}
    <div class="alert alert-success product_added text-center">
        Товар добален в корзину <i class="fa-solid fa-check"></i>
    </div>

    {{-- Поиск на сайте --}}
    <div class="mask w-100 h-100"></div>
    <div class="search">
        <form action="/product/find" method="post" class="form-control mb-4">
            @csrf
            <h2 class="text-center mt-2 mb-5">Форма поиска</h2>
            <button type="button" class="btn close m-2"><i class="fa-solid fa-xmark"></i></button>
            <div class="d-flex align-items-top mb-2">
                <input type="text" name="find" class="form-control d-block border border-1 rounded-2 px-2 me-3" placeholder="Поиск" autocomplete="off">
                <button type="submit" class="btn btn-warning">Найти</button>
            </div>
        </form>
    </div>

    {{-- Кнопки перехода вверх/вниз по странице --}}
    <button id="downBtn" class="btn btn-secondary"><i class="fa-solid fa-chevron-down"></i></button>
    <button id="upBtn" class="btn btn-secondary"><i class="fa-solid fa-chevron-up"></i></button>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('/public/js/options.js') }}"></script>
    <script src="{{ asset('/public/js/app.js') }}"></script>
    <script src="{{ asset('/public/bootstrap_js/bootstrap.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/c0c3afc1db.js" crossorigin="anonymous"></script>

    <script>
        // Добавить товар в корзину
        let addBasket = function(val) {
            $.ajax({
                url: '/basket_post',
                type: 'post',
                dataType: 'html',
                cach: false,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'item_id': val
                },
                success: function(data) {
                    $('#basket_count').text(+$('#basket_count').text() + 1);
                    $('.product_added').slideDown();
                    setTimeout(() => {
                        $('.product_added').slideUp();
                    }, 2000);
                }
            });
        };
    </script>

    @yield('script')
</body>
</html>