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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {

    Route::get('/eventos/provide', 'EventoController@provide')->name('eventos.provide');
    Route::get('/eventos/getEtiquetas', 'EventoController@getEtiquetas')->name('eventos.getEtiquetas');
    Route::get('/eventos/getUsers', 'EventoController@getUsers')->name('eventos.getUsers');
    Route::get('/eventos/{evento}/destroy', 'EventoController@destroy')->name('eventos.destroy');
    Route::resource('eventos', 'EventoController')->except(['destroy', 'show']);
    Route::get('/etiquetas/{etiqueta}/needApproval', 'EtiquetaController@needApproval')->name('etiquetas.needApproval');
});
Route::group(['middleware' => 'can:admin'], function () {
    Route::get('/users/provide', 'UserController@provide')->name('users.provide');
    Route::resource('users', 'UserController');

});
Route::middleware(['can:administracion_profesor'])->group(function () {
    Route::match(['get', 'post'], '/peticions/index', 'PeticionController@index')->name('peticions.index');
    Route::get('/peticions/{peticion}/update', 'PeticionController@update')->name('peticions.update');
    Route::get('/peticions/{peticion}/destroy', 'PeticionController@destroy')->name('peticions.destroy');
    Route::resource('peticions', 'PeticionController')->except(['index', 'update', 'destroy']);
});
Route::group(['middleware' => 'can:administracion'], function () {
    Route::get('/etiquetas/{etiqueta}/destroy', 'EtiquetaController@destroy')->name('etiquetas.destroy');
    Route::resource('/etiquetas', 'EtiquetaController')->except(['destroy', 'show']);
});
