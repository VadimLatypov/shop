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
            <?php
                $sum = 0;
                for($i = 0; $i < count($products); $i++):
                    $sum += $products[$i]['price'] * $products_count[$products[$i]['id']];
            ?>
                <div class="row_prod row_prod_<?=$products[$i]['id']?> d-flex justify-content-between align-items-center rounded-3 pe-3 mb-3">
                    <img src="img/products/<?=$products[$i]['img_main']?>" alt="<?=$products[$i]['title']?>">
                    <h4 class="w-50"><?=$products[$i]['title']?></h4>
                    <span class="item_sum_<?=$products[$i]['id']?>"><?=$products[$i]['price'] * $products_count[$products[$i]['id']]?> ₽</span>
                    
                    <div class="d-flex align-items-center">
                        <!-- Уменьшить количество товаров -->
                        {{-- <form action="/basket_post" method="POST" class="item-count"> --}}
                        <form class="item-count">
                            @csrf
                            <input type="hidden" name="item_minus" value="<?=$products[$i]['id']?>">
                            <?php if($products_count[$products[$i]['id']] == 1): ?>
                                {{-- <button type="button" class="button border-0 rounded-3 me-2" disabled><i class="fa-solid fa-minus"></i></button> --}}
                                <button type="button" class="button border-0 rounded-3 me-2 item_minus item_minus_<?=$products[$i]['id']?>" onclick="reduceItem(<?=$products[$i]['id']?>, <?=$products[$i]['price']?>)" disabled><i class="fa-solid fa-minus"></i></button>
                            <?php else: ?>
                                {{-- <button type="submit" class="button border-0 rounded-3 me-2"><i class="fa-solid fa-minus"></i></button> --}}
                                <button type="button" class="button border-0 rounded-3 me-2 item_minus item_minus_<?=$products[$i]['id']?>" onclick="reduceItem(<?=$products[$i]['id']?>, <?=$products[$i]['price']?>)"><i class="fa-solid fa-minus"></i></button>
                            <?php endif; ?>
                        </form>

                        <span class="item_count_<?=$products[$i]['id']?>"><?=$products_count[$products[$i]['id']]?></span>

                        
                        <!-- Увеличить количество товаров -->
                        {{-- <form action="/basket_post" method="POST" class="item-count"> --}}
                        <form class="item-count">
                            @csrf
                            <input type="hidden" name="item_plus" value="<?=$products[$i]['id']?>">
                            {{-- <button type="submit" class="button border-0 rounded-3 ms-2"><i class="fa-solid fa-plus"></i></button> --}}
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
            <?php endfor; ?>

            
            {{-- Authentication Links --}}
            @guest
                <div class="row text-center m-auto col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xxl-3">
                    <a href="/login" class="btn btn-success mb-4">Войдите в аккаунт для покупки</a>
                </div>
            @else
                <!-- Подключение системы оплаты -->
                <?php
                    //Секретный ключ интернет-магазина
                    $key = "XkZMYW56NzVbNV1aekxGNVxvT3xwVHExZ005"; // ЭЦП
                    
                    $fields = array();
                    
                    // Добавление полей формы в ассоциативный массив
                    $fields["WMI_MERCHANT_ID"] = "119175088534"; // ID магазина (проекта)
                    $fields["WMI_PAYMENT_AMOUNT"] = $sum; // стоимость товаров
                    $fields["WMI_CURRENCY_ID"] = "643"; // код валюты
                    $fields["WMI_PAYMENT_NO"] = time(); // уникальный номер платежа (можно использовать time())
                    $fields["WMI_DESCRIPTION"] = "BASE64:".base64_encode("Здесь будет описание платежа"); // описание платежа
                    $fields["WMI_EXPIRED_DATE"] = date('Y-m-d')."T23:59:59"; // до какого момента будет доступна оплата (сегодня до полуночи)
                    $fields["WMI_SUCCESS_URL"] = ".../success"; // адрес перехода на страницу после успешной оплаты
                    $fields["WMI_FAIL_URL"] = ".../fail"; // адрес перехода на страницу после неуспешной оплаты
                    $fields["id_of_product"] = "ID-234567"; // свои дополнительные параметры (будут отображены на старнице после успешной оплаты) - их может быть несколько

                    //Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
                    //$fields["WMI_PTENABLED"] = array("UnistreamRUB", "SberbankRUB", "RussianPostRUB");
                    
                    //Сортировка значений внутри полей
                    foreach($fields as $name => $val) {
                        if(is_array($val)) {
                            usort($val, "strcasecmp");
                            $fields[$name] = $val;
                        }
                    }
                    
                    // Формирование сообщения, путем объединения значений формы,
                    // отсортированных по именам ключей в порядке возрастания.
                    uksort($fields, "strcasecmp");
                    $fieldValues = "";
                    
                    foreach($fields as $value) {
                        if(is_array($value))
                            foreach($value as $v) {
                                //Конвертация из текущей кодировки (UTF-8)
                                //необходима только если кодировка магазина отлична от Windows-1251
                                $v = iconv("utf-8", "windows-1251", $v);
                                $fieldValues .= $v;
                            }
                        else {
                            //Конвертация из текущей кодировки (UTF-8)
                            //необходима только если кодировка магазина отлична от Windows-1251
                            $value = iconv("utf-8", "windows-1251", $value);
                            $fieldValues .= $value;
                        }
                    }
                    
                    // Формирование значения параметра WMI_SIGNATURE, путем
                    // вычисления отпечатка, сформированного выше сообщения,
                    // по алгоритму MD5 и представление его в Base64
                    $signature = base64_encode(pack("H*", md5($fieldValues . $key)));
                    
                    //Добавление параметра WMI_SIGNATURE в словарь параметров формы
                    $fields["WMI_SIGNATURE"] = $signature;
                    
                    // Формирование HTML-кода платежной формы
                    print "<form action='https://wl.walletone.com/checkout/checkout/Index' method='POST' class='row text-center m-auto col-xs-10 col-sm-6 col-md-4 col-lg-3'>";
                    // поля сделать скрытыми
                    foreach($fields as $key => $val) {
                        if(is_array($val))
                            foreach($val as $value) {
                                print "<input type='hidden' name='$key' value='$value'/>";
                            }
                        else
                            print "<input type='hidden' name='$key' value='$val'/>";
                    }
                    // Кнопка своя
                    print "<button type='submit' class='btn btn-success mb-4 btn_buy'>Приобрести (<b><span>$sum</span> ₽</b>)</button></form>";
                ?>
            @endguest
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