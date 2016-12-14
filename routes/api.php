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

Route::get('/data', function (\App\Model\Nasabah $nasabah) {
    return $nasabah->all();
})->middleware('auth:api');

Route::post('cekuidnis', 'TransaksiController@CekUidNis')->middleware('auth:api');
Route::post('belanja', 'TransaksiController@belanja')->middleware('auth:api');