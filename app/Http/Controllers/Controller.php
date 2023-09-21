<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function basket_count() {
        $cart = new Basket();
        $basket_count = 0;
        if ($cart->countUnitProductInBasket()) {
            $products_count = $cart->countUnitProductInBasket();
            foreach ($products_count as $el) {
                $basket_count += $el;
            }
        }
        return $basket_count;
    }
}
