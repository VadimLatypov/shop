<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Product;

class BasketController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Корзина товаров',
            'basket_count' => $this->basket_count()
        ];
        
        $cart = new Basket();
        // $cart->deleteSession();

        // Проверка сессии и вывод товаров
        if(!$cart->isSetSession())
            $data['empty'] = 'Корзина пуста';
        else {
            $products = new Product();
            $data['products'] = $products->getProductsCart($cart->getSession());
            $data['products_count'] = $cart->countUnitProductInBasket();
        }

        return view('basket/index', $data);
    }

    // Добавить товар в корзину
    public function post() {
        $cart = new Basket();

        // Добавить товар в сессию из формы
        if(isset($_POST['item_id'])) {
            $cart->addToCart($_POST['item_id']);
            // return redirect('/basket')->with('success', 'Товар добавлен');
        }

        // Увеличить количество товара в сессии из формы
        if(isset($_POST['item_plus'])) {
            $cart->addToCart($_POST['item_plus']);
            // return redirect('/basket');
        }

        // Уменьшить количество товара в сессии из формы
        if(isset($_POST['item_minus'])) {
            $cart->minusFromCart($_POST['item_minus']);
            // return redirect('/basket');
        }

        // Удалить товар в сессии из формы
        if(isset($_POST['del_item'])) {
            $products_count = $cart->countUnitProductInBasket();
            $res = 0;
            foreach ($products_count as $el) {
                $res += $el;
            }
            
            if($res > 1 && count($products_count) == 1)
                $cart->deleteSession();
            else if($res > 1 && count($products_count) > 1)
                $cart->deleteFromCart($_POST['del_item']);
            else
                $cart->deleteSession();
            
            return redirect('/basket');
        }

        // Очистить корзину
        if(isset($_POST['clear_cart'])) {
            $cart->deleteSession();
            return redirect('/basket')->with('success', 'Корзина очищена');
        }
    }

    // Подтверждение заказа
    public function order() {
        $data = [
            'title' => 'Корзина товаров',
            'basket_count' => $this->basket_count()
        ];
        
        $cart = new Basket();

        // Проверка сессии и вывод товаров
        if(!$cart->isSetSession())
            return redirect('/basket')->with('success', 'Необходимо выбрать хотя бы один товар');
        else {
            $products = new Product();
            $data['products'] = $products->getProductsCart($cart->getSession());
            $data['products_count'] = $cart->countUnitProductInBasket();
        }

        return view('basket/order', $data);
    }
}
