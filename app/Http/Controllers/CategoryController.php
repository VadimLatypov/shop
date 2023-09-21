<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    private function data($title, $subtitle, $prod_cat, $category, $subcategory) {
        $data = [
            'title' => $title,
            'subtitle' => $subtitle,
            'products' => DB::select("SELECT * FROM products WHERE category = '" . $prod_cat . "' ORDER BY title"),
            'category' => $category,
            'subcategory' => $subcategory,
            'basket_count' => $this->basket_count()
        ];
        return $data;
    }

    // Мужчинам
    public function man() {
        $data = [
            'title' => 'Товары для мужчин',
            'subtitle' => 'Мужчинам',
            'products' => DB::select("SELECT * FROM products WHERE category LIKE 'муж%' ORDER BY RAND()"),
            'category' => 'man',
            'subcategory' => '',
            'basket_count' => $this->basket_count()
        ];
        return view("category/index", $data);
    }

    public function manShoes() {
        $data = $this->data('Товары для мужчин', 'Мужская обувь', 'муж/обувь', 'man', 'Обувь');
        return view("category/index", $data);
    }

    public function manClothes() {
        $data = $this->data('Товары для мужчин', 'Мужская одежда', 'муж/одежда', 'man', 'Одежда');
        return view("category/index", $data);
    }

    public function manAccessories() {
        $data = $this->data('Товары для мужчин', 'Мужская аксессуары', 'муж/аксессуары', 'man', 'Аксессуары');
        return view("category/index", $data);
    }

    // Женщинам
    public function woman() {
        $data = [
            'title' => 'Товары для женщин',
            'subtitle' => 'Женщинам',
            'products' => DB::select("SELECT * FROM products WHERE category LIKE 'жен%' ORDER BY RAND()"),
            'category' => 'woman',
            'subcategory' => '',
            'basket_count' => $this->basket_count()
        ];
        return view("category/index", $data);
    }

    public function womanShoes() {
        $data = $this->data('Товары для женщин', 'Женская обувь', 'жен/обувь', 'woman', 'Обувь');
        return view("category/index", $data);
    }

    public function womanClothes() {
        $data = $this->data('Товары для женщин', 'Женская одежда', 'жен/одежда', 'woman', 'Одежда');
        return view("category/index", $data);
    }

    public function womanAccessories() {
        $data = $this->data('Товары для женщин', 'Женская аксессуары', 'жен/аксессуары', 'woman', 'Аксессуары');
        return view("category/index", $data);
    }

    // Для дома
    public function home() {
        $data = [
            'title' => 'Товары для дома',
            'subtitle' => 'Для дома',
            'products' => DB::select("SELECT * FROM products WHERE category LIKE 'дом%' ORDER BY RAND()"),
            'category' => 'home',
            'subcategory' => '',
            'basket_count' => $this->basket_count()
        ];
        return view("category/index", $data);
    }

    public function homeBathroom() {
        $data = $this->data('Товары для дома', 'Товары для ванной', 'дом/ванная', 'home', 'Ванная');
        return view("category/index", $data);
    }

    public function homeKitchen() {
        $data = $this->data('Товары для дома', 'Товары для кухни', 'дом/кухня', 'home', 'Кухня');
        return view("category/index", $data);
    }

    public function homeBedroom() {
        $data = $this->data('Товары для дома', 'Товары для спальни', 'дом/спальня', 'home', 'Спальня');
        return view("category/index", $data);
    }
}
