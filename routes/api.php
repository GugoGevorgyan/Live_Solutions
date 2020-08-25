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

Route::resource('/brand', 'BrandController');
Route::resource('/category','CategoryController');

Route::prefix('/Admin')->group(function () {
    Route::resource('/', 'AdminController');
    Route::post('/attach_new_product', 'AdminController@attach_new_product');
    Route::post('/detach_product', 'AdminController@detach_product');
    Route::post('/get', 'AdminController@getsome');
    Route::post('/company_suggest', 'AdminController@company_suggest');
    Route::post('accept', 'AdminController@accept');
    Route::delete('reject', 'AdminController@reject');
});

Route::get('/verify', 'RegisterController@verify');


//Route::put('/product/edit/{product}', 'ProductsController@product_edit'); ->admin.@edit
//Route::delete('/product/delete/{product}', 'ProductsController@product_delete');-> admin.@destroy










