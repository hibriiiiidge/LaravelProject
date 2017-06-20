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
Route::get('/bases', 'BaseTypesController@index');
Route::get('/base/create', 'BaseTypesController@create');
Route::post('/base/store', 'BaseTypesController@store');
