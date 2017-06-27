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

Route::get('/item_categories', 'ItemCategoryApiController@index');
Route::get('/item_categories/{category_id}', 'ItemCategoryApiController@chkList');

Route::get('/item_makers/{categoryId}', 'ItemMakerApiController@index');
