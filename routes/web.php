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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('threads/new', 'ThreadController@create')->name('thread.new');
Route::post('threads/store', 'ThreadController@store')->name('thread.store');
Route::get('threads/{thread}', 'ThreadController@show')->name('thread.show');
Route::get('threads/{thread}/edit', 'ThreadController@edit')->name('thread.edit');
Route::post('threads/{thread}/reply', 'ThreadController@reply')->name('thread.reply');
Route::delete('threads/{thread}/delete', 'ThreadController@destroy')->name('thread.delete');

Route::get('reply/{reply}/edit', 'ReplyController@edit')->name('reply.edit');
Route::post('reply/{reply}', 'ReplyController@update')->name('reply.update');
Route::delete('reply/{reply}/delete', 'ReplyController@destroy')->name('reply.delete');

Route::get('category/{category}', 'ThreadController@category')->name('thread.category');

Route::post('search', 'ThreadController@search')->name('thread.search');

