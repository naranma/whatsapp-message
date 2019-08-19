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

Route::group(['prefix' => 'message'], function () {
    Route::get('/', 'MessageController@index')->name('message.index');
    Route::get('/create', 'MessageController@create')->name('message.create');
    Route::post('/', 'MessageController@store')->name('message.store');
    Route::get('/{id}', 'MessageController@show')->name('message.show');
    Route::get('/{id}/edit', 'MessageController@edit')->name('message.edit');
    Route::put('/{id}', 'MessageController@update')->name('message.update');
    Route::delete('/{id}', 'MessageController@destroy')->name('message.destroy');

    Route::post('/{id}/send', 'MessageController@send')->name('message.send');

    Route::get('/{id}/start', 'MessageController@start')->name('message.start');
    Route::get('/{id}/stop', 'MessageController@stop')->name('message.stop');
    Route::get('/{id}/clear', 'MessageController@clear')->name('message.clear');

    Route::get('/{id}/createwhatsapp', 'MessageController@createWhatsapp')->name('message.createwhatsapp');
    Route::get('/{id}/qrcode', 'MessageController@getWhatsappQRCode')->name('message.qrcode');
});
