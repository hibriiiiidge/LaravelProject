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
    if (Auth::guest()) {
      return view('auth.login');
    }
    else{
      return view('home');
    }
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//client
Route::get('/client/create', 'ClientsController@create');       //新規登録ページ
Route::post('/client/store', 'ClientsController@store');        //登録

//client & request_detail
Route::get('/client/{client_id}/show/{requestDetail_id}', 'ClientsController@edit'); //詳細表示
Route::patch('/client/{client_id}/show/{requestDetail_id}', 'ClientsController@update'); //update
Route::delete('/client/{client_id}/show/{requestDetail_id}', 'ClientsController@destroy'); //削除

//request
Route::get('/request', 'RequestsController@index');         //一覧表示

//マスタデータ系
//user(staff)
Route::get('/users', 'UsersController@index');                  //一覧表示
Route::get('/user/edit/{id}', 'UsersController@edit')
        ->where('id', '[1-9][0-9]*');                           //編集
Route::patch('/user/update/{id}', 'UsersController@update')
        ->where('id', '[1-9][0-9]*');                           //アップデート
Route::delete('/user/destroy/{id}', 'UsersController@destroy')
        ->where('id', '[1-9][0-9]*');                           //論理削除
//base_types
Route::get('/bases', 'BaseTypesController@index');              //一覧表示
Route::get('/base/create', 'BaseTypesController@create');       //新規登録ページへの遷移
Route::post('/base/store', 'BaseTypesController@store');        //新規登録
Route::get('/base/edit/{id}', 'BaseTypesController@edit')
        ->where('id', '[1-9][0-9]*');                           //編集
Route::patch('/base/update/{id}', 'BaseTypesController@update')
        ->where('id', '[1-9][0-9]*');                           //アップデート

//routes
Route::get('/routes', 'RoutesController@index');              //一覧表示
Route::get('/route/create', 'RoutesController@create');       //新規登録ページへの遷移
Route::post('/route/store', 'RoutesController@store');        //新規登録
Route::get('/route/edit/{id}', 'RoutesController@edit')
        ->where('id', '[1-9][0-9]*');                           //編集
Route::patch('/route/update/{id}', 'RoutesController@update')
        ->where('id', '[1-9][0-9]*');                           //アップデート

//item_category
Route::get('/item_categories', 'ItemCategoriesController@index');              //一覧表示
Route::get('/item_category/create', 'ItemCategoriesController@create');       //新規登録ページへの遷移
Route::post('/item_category/store', 'ItemCategoriesController@store');        //新規登録
Route::get('/item_category/edit/{id}', 'ItemCategoriesController@edit')
        ->where('id', '[1-9][0-9]*');                           //編集
Route::patch('/item_category/update/{id}', 'ItemCategoriesController@update')
        ->where('id', '[1-9][0-9]*');                           //アップデート

//item_maker
Route::get('/item_makers', 'ItemMakersController@index');              //一覧表示
Route::get('/item_maker/create', 'ItemMakersController@create');       //新規登録ページへの遷移
Route::post('/item_maker/store', 'ItemMakersController@store');        //新規登録
Route::get('/item_maker/edit/{id}', 'ItemMakersController@edit')
        ->where('id', '[1-9][0-9]*');                           //編集
Route::patch('/item_maker/update/{id}', 'ItemMakersController@update')
        ->where('id', '[1-9][0-9]*');                           //アップデート

//category_maker
Route::get('/categories_makers', 'CategoryMakerController@index');              //一覧表示
Route::get('/category_maker/create', 'CategoryMakerController@create');       //新規登録ページへの遷移
Route::post('/category_maker/store', 'CategoryMakerController@store');        //新規登録
Route::get('/category_maker/edit', 'CategoryMakerController@edit');          //編集
Route::patch('/category_maker/update/{id}', 'CategoryMakerController@update')      //アップデート
        ->where('id', '[1-9][0-9]*');
