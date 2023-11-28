@extends('layout/main')

@section('page-title')
{{ $title }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mt-5">Корзина товаров</h1>

        @if(!isset($empty))
            {{-- Очистить корзину --}}
            <form action="/basket_post" method="POST" class="clear-cart">
                @csrf

                <input type="hidden" name="clear_cart" value="all">
                <button type="submit" class="btn btn-danger mt-5">Очистить корзину</button>
            </form>
        @endif
    </div>
    <?php if(isset($empty)): ?>
        <p><?=$empty?>.<br>Посмотрте на главную, чтобы выбрать товары или найдите нужное в категориях</p>
        <a href="/" class="btn btn-warning">Перейти на главную</a>
    <?php else: ?>
        <div class="products">
            {{-- Подсчет итоговой суммы --}}
            <?php
                $sum = 0;
                for($i = 0; $i < count($products); $i++):
                    $sum += $products[$i]['price'] * $products_count[$products[$i]['id']];
            ?>
                {{-- Строка товара --}}
                <div class="row_prod row_prod_<?=$products[$i]['id']?> d-flex justify-content-between align-items-center rounded-3 pe-3 mb-3">
                    <img src="/public/img/products/<?=$products[$i]['img_main']?>" alt="<?=$products[$i]['title']?>">
                    <h4 class="col-md-6 col-sm-4 col-xs-3"><?=$products[$i]['title']?></h4>
                    <span class="item_sum_<?=$products[$i]['id']?>"><?=$products[$i]['price'] * $products_count[$products[$i]['id']]?> ₽</span>
                    
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <!-- Уменьшить количество товаров -->
                            <form class="item-count">
                                @csrf
                                <input type="hidden" name="item_minus" value="<?=$products[$i]['id']?>">
                                <?php if($products_count[$products[$i]['id']] == 1): ?>
                                    <button type="button" class="button border-0 rounded-3 me-2 item_minus item_minus_<?=$products[$i]['id']?>" onclick="reduceItem(<?=$products[$i]['id']?>, <?=$products[$i]['price']?>)" disabled><i class="fa-solid fa-minus"></i></button>
                                <?php else: ?>
                                    <button type="button" class="button border-0 rounded-3 me-2 item_minus item_minus_<?=$products[$i]['id']?>" onclick="reduceItem(<?=$products[$i]['id']?>, <?=$products[$i]['price']?>)"><i class="fa-solid fa-minus"></i></button>
                                <?php endif; ?>
                            </form>
    
                            <span class="item_count_<?=$products[$i]['id']?>"><?=$products_count[$products[$i]['id']]?></span>
    
                            
                            <!-- Увеличить количество товаров -->
                            <form class="item-count">
                                @csrf
                                <input type="hidden" name="item_plus" value="<?=$products[$i]['id']?>">
                                <button type="button" class="button border-0 rounded-3 ms-2" onclick="addItem(<?=$products[$i]['id']?>, <?=$products[$i]['price']?>)"><i class="fa-solid fa-plus"></i></button>
                            </form>
                        </div>
    
                        <!-- Удаление элемента -->
                        <form action="/basket_post" method="POST" class="del-item">
                            @csrf
                            <input type="hidden" name="del_item" value="<?=$products[$i]['id']?>">
                            <button type="submit" class="btn" title="Удалить из корзины"><i class="fa-solid fa-trash-can"></i></button>                        
                        </form>
                    </div>
                </div>
            <?php endfor; ?>
            
            {{-- Ссылка на подтверждение заказа --}}
            <div class="row text-center m-auto col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xxl-3">
                <a href="/basket/order" class="btn btn-success mb-4 btn_buy">Перейти к оформлению (<b><span><?= $sum ?></span> ₽</b>)</a>
            </div>
        </div>
    <?php endif; ?>
@endsection


@section('script')
    <script>
        // Убавить товар
        let reduceItem = function(val, price) {
            $.ajax({
                url: '/basket_post',
                type: 'post',
                dataType: 'html',
                cach: false,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'item_minus': val
                },
                success: function(data) {
                    let new_count = +$(`.item_count_${val}`).text() - 1;
                    let new_price = new_count * price;

                    $('#basket_count').text(+$('#basket_count').text() - 1);
                    $(`.item_count_${val}`).text(new_count);
                    $(`.item_sum_${val}`).text(new_price + ' ₽');

                    // Общая сумма
                    $('.btn_buy > b > span').text(+$('.btn_buy > b > span').text() - price);

                    if(new_count <= 1)
                        $(`.item_minus_${val}`).prop('disabled', true);
                }
            });
        };

        // Прибавить товар
        let addItem = function(val, price) {
            $.ajax({
                url: '/basket_post',
                type: 'post',
                dataType: 'html',
                cach: false,
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'item_plus': val
                },
                success: function(data) {
                    let new_count = +$(`.item_count_${val}`).text() + 1;
                    let new_price = new_count * price;

                    $('#basket_count').text(+$('#basket_count').text() + 1);
                    $(`.item_count_${val}`).text(new_count);
                    $(`.item_sum_${val}`).text(new_price + ' ₽');

                    // Общая сумма
                    $('.btn_buy > b > span').text(+$('.btn_buy > b > span').text() + price);
                    
                    if(new_count > 1)
                        $(`.item_minus_${val}`).prop('disabled', false);
                }
            });
        };
    </script>
@endsection