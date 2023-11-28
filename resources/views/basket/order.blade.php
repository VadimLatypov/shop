@extends('layout/main')

@section('page-title')
{{ $title }}
@endsection

@section('basket-count')
{{ $basket_count }}
@endsection

@section('content')
{{-- {{ print_r($products) }}
<div>___________________________________</div>
{{ print_r($products_count) }}
<div>___________________________________</div> --}}

    <div>
        <h1 class="mt-5 mb-3">Подтверждение заказа</h1>
        <table class="table table-sm table-striped table-bordered table-hover text-center">
            <thead>
                <th>№</th>
                <th>Наименование</th>
                <th>Количество</th>
                <th>Стоимость</th>
            </thead>
            <tbody>
                <?php
                    $sum = 0;
                    for($i = 0; $i < count($products); $i++):
                        $sum += $products[$i]['price'] * $products_count[$products[$i]['id']];
                ?>
                    <tr class="">
                        <th><?=$i + 1?></th>
                        <td><?=$products[$i]['title']?></td>
                        <td><?=$products_count[$products[$i]['id']]?> шт.</td>
                        <td><?=$products[$i]['price'] * $products_count[$products[$i]['id']]?> ₽</td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

            
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
                print "<button type='submit' class='btn btn-success mb-4'>Купить за <b><span>$sum</span> ₽</b></button></form>";
            ?>
        @endguest
    </div>
@endsection