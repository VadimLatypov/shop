<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

session_start();

class Basket extends Model
{
    use HasFactory;

    private $session_name = 'cart';

    // Проверка, установлена ли сессия сейчас
    public function isSetSession() {
        return isset($_SESSION[$this->session_name]);
    }

    // Удаление сессии
    public function deleteSession() {
        unset($_SESSION[$this->session_name]);
    }

    // Получение значения сессии
    public function getSession() {
        return $_SESSION[$this->session_name];
    }

    // Добавление товаров в сессию
    public function addToCart($itemID) {
        if(!$this->isSetSession())
            $_SESSION[$this->session_name] = $itemID;
        else {
            $_SESSION[$this->session_name] = $_SESSION[$this->session_name] . ',' . $itemID;
        }
    }

    // Удаление товара из сессии
    public function deleteFromCart($itemID) {
        $items = explode(',', $_SESSION[$this->session_name]);
        foreach ($items as $key => $el) {
            if($el == $itemID)
                unset($items[$key]);
        }
        $_SESSION[$this->session_name] = implode(',', $items);
    }

    // Уменьшить количество товара в сессии
    public function minusFromCart($itemID) {
        $items = explode(',', $_SESSION[$this->session_name]);
        foreach ($items as $key => $el) {
            if($el == $itemID) {
                unset($items[$key]);
                break;
            }
        }
        $_SESSION[$this->session_name] = implode(',', $items);
    }

    // Подсчет элементов в сессии
    public function countItems() {
        if(!$this->isSetSession())
            return 0;
        else {
            $items = explode(',', $_SESSION[$this->session_name]);
            return count($items);
        }
    }

    // Подсчет количества каждого товара в сессии
    public function countUnitProductInBasket() {
        if(!$this->isSetSession())
            return 0;
        else {
            $items = explode(',', $_SESSION[$this->session_name]);
            return array_count_values($items);
        }
    }
}
