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

Route::get('/', 'PostsController@index');
Route::get('/posts/{id}', 'PostsController@show')
      ->where('id', '[1-9][0-9]*');
Route::get('/posts/create', 'PostsController@create');
Route::post('/posts/store', 'PostsController@store');
Route::get('/posts/edit/{id}', 'PostsController@edit')
      ->where('id', '[1-9][0-9]*');
Route::patch('/posts/{id}', 'PostsController@update')
      ->where('id', '[1-9][0-9]*');
Route::delete('/posts/{id}', 'PostsController@destroy')
      ->where('id', '[1-9][0-9]*');
// Route::get('/posts/destroy/{id}', 'PostsController@destroy')
//       ->where('id', '[1-9][0-9]*');

Route::post('/posts/comments/{post_id}', 'CommentsController@store');
// Route::get('/posts/{post_id}/comments/{comment_id}', 'CommentsController@destroy');
Route::delete('/posts/{post_id}/comments/{comment_id}', 'CommentsController@destroy');
