<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1'], function(){
	
	// list all items
	Route::get("items", ['uses' => 'Api\ItemController@index']);

	// Show Item Details
	Route::get("items/{id}", ['uses' => 'Api\ItemController@show']);
	
	// bid on Particular Item
	Route::post("items/{id}", ['uses' => 'Api\ItemController@bid']);

});