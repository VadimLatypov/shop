<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;

    // Отношение "один ко многим"
    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    // Получение записей для корзины
    public function getProductsCart($items) {
        // Преобразование из stdClass в Array
        $result = json_decode(json_encode(DB::select("SELECT * FROM `products` WHERE `id` IN ($items) ORDER BY `category`")), true);
        return $result;
    }
}
