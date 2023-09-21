<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Главная',
            // 'products' => Product::all(),
            'products' => DB::select('SELECT * FROM products ORDER BY RAND() LIMIT 12'),
            'basket_count' => $this->basket_count()
        ];
        return view("static/index", $data);
    }
}
