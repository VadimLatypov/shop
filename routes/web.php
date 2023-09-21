<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StaticController@index');

// Категории и подкатегории
Route::get('/category/man', 'CategoryController@man');
Route::get('/category/man/accessories', 'CategoryController@manAccessories');
Route::get('/category/man/clothes', 'CategoryController@manClothes');
Route::get('/category/man/shoes', 'CategoryController@manShoes');

Route::get('/category/woman', 'CategoryController@woman');
Route::get('/category/woman/accessories', 'CategoryController@womanAccessories');
Route::get('/category/woman/clothes', 'CategoryController@womanClothes');
Route::get('/category/woman/shoes', 'CategoryController@womanShoes');

Route::get('/category/home', 'CategoryController@home');
Route::get('/category/home/bathroom', 'CategoryController@homeBathroom');
Route::get('/category/home/kitchen', 'CategoryController@homeKitchen');
Route::get('/category/home/bedroom', 'CategoryController@homeBedroom');

// Страница товара
Route::get('/product/{id}','ProductsController@show');

// Авторизация и регистрация
Auth::routes();
Route::get('/user', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Корзина
Route::get('/basket', 'BasketController@index');
Route::post('/basket_post', 'BasketController@post');