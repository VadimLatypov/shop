<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [
            'title' => 'Личный кабинет',
            'basket_count' => $this->basket_count()
        ];
        return view('home', $data);
    }
}
