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


Auth::routes();

Route::get('/', 'HomeController@index');
Route::get("item/{id}", 'HomeController@show');
Route::get('item/{id}/bid', 'HomeController@bid');
Route::get("about", "HomeController@about");

/*============================================
=            Items Routes/Methods            =
============================================*/
Route::get('dashboard', 'ItemController@index');
Route::post('dashboard', 'ItemController@store');

Route::get('items/{id}', 'ItemController@edit');
Route::post('items/{id}', 'ItemController@update');
Route::delete('items/{id}', 'ItemController@destroy');

Route::delete("items/{id}/delete", "ItemController@deleteItem");
Route::get("items/{id}/restore", "ItemController@restoreItem");


Route::post("profile", 'ItemController@editProfile');

