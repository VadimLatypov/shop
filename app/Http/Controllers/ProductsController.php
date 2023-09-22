<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $data = [
            'title' => 'Страница с товаром',
            'product' => Product::find($id),
            'basket_count' => $this->basket_count(),
            'reviews' => Review::where('product_id', $id)->orderBy('id', 'desc')->get()
        ];
        return view("category/show", $data);
    }

    public function find(Request $request)
    {
        $find = $request->input('find');
        $data = [
            'title' => 'Поиск товаров',
            'products' => DB::select("SELECT * FROM products WHERE title LIKE '%$find%'"),
            'basket_count' => $this->basket_count(),
            'find' => $find
        ];
        if(count($data['products']) > 0)
            return view("static/find", $data)->with('success', 'Вот, что удалось найти по вашему запросу');
        else
            return redirect('/')->with('warning', 'По вашему запросу ничего не найдено');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
