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



Route::namespace('Api')->group(function () {



    ///apis de supervivientes


    Route::prefix('supervivientes')->name('supervivientes')->group(function () {
        Route::get('/', 'SupervivienteController@index')->name('index');
        Route::get('/{id}', 'SupervivienteController@show')->name('show')->where(['id' => '[0-9]+']);
        Route::post('/', 'SupervivienteController@store')->name('store');
        Route::put('/{id}', 'SupervivienteController@update')->name('update');
//Reportar infectados
        Route::post('/reportarinfectado/', 'SupervivienteController@reporteInfectado')->name('reporteInfectado');
//Transacciones
        Route::post('/transacciones/', 'SupervivienteController@transacciones')->name('transacciones');
//Reportes
Route::get('/reportes/infectados/', 'SupervivienteController@infectados')->name('infectados');
Route::get('/reportes/items/', 'SupervivienteController@items')->name('items');
Route::get('/reportes/puntosporinfectado/', 'SupervivienteController@puntosinfectados')->name('puntosinfectados');


    });

///fin apis supervivientes




});