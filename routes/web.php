<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Products Routes
Route::get('products', 'ProductController@index');
Route::get('products/{product}', 'ProductController@show');
Route::post('products', 'ProductController@store');
Route::post('product-update', 'ProductController@update');
Route::post('product-delete', 'ProductController@destroy');

//Order Routes
Route::get('orders', 'OrderController@index')->middleware('admin');
Route::get('suppliers', 'OrderController@suppliers')->middleware('admin');
Route::get('get-orders', 'OrderController@getOrders');
Route::get('orders/{order}', 'OrderController@show');
Route::post('orders', 'OrderController@store')->middleware('admin');
Route::post('order-update', 'OrderController@update');
Route::post('order-delivered', 'OrderController@delivered');
Route::post('order-delete', 'OrderController@destroy')->middleware('admin');
