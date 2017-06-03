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
      return view('user.home');
    }
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//user
Route::get('/users', 'UsersController@index');
Route::get('/users/edit/{id}', 'UsersController@edit')
        ->where('id', '[1-9][0-9]*');
Route::patch('/users/update/{id}', 'UsersController@update')
        ->where('id', '[1-9][0-9]*');
Route::delete('/users/destroy/{id}', 'UsersController@destroy')
        ->where('id', '[1-9][0-9]*');
