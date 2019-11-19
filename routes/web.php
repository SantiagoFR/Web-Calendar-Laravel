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

Route::get('/users/provide', 'UserController@provide')->name('users.provide');
Route::resource('users', 'UserController');

Route::get('/eventos/provide','EventoController@provide')->name('eventos.provide');
Route::get('/eventos/{evento}/destroy','EventoController@destroy')->name('eventos.destroy');
Route::resource('eventos', 'EventoController')->except(['destroy','show']);

Route::resource('etiquetas', 'EtiquetaController');