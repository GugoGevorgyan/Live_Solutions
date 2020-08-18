<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('/login', 'LoginController');
Route::resource('/register', 'RegisterController');
Route::resource('/admin', 'ProductsController');
Route::resource('/brand', 'BrandController');
Route::get('/verify', 'RegisterController@verify');
Route::post('/attach_new_product', 'ProductsController@attach_new_product');

Route::put('/product/edit/{product}', 'ProductsController@product_edit');


Route::delete('/product/delete/{product}', 'ProductsController@product_delete');

Route::post('/get', 'ProductsController@getsome');


Route::post('/getBrand', 'ProductsController@getBrand');


