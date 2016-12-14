<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => 'web'], function () {
    Route::get('login', [
        'uses' => 'AuthenticationController@getLogin',
        'as'   => 'get.login'
    ]);
    Route::post('login', [
        'uses' => 'AuthenticationController@postLogin',
        'as'   => 'post.login'
    ]);
    Route::get('logout', [
        'uses' => 'AuthenticationController@logout',
        'as'   => 'get.logout'
    ]);
});

Route::group(['middleware'=>'auth'], function() {
    //halaman-Utama
    Route::get('/', [
        'uses'=>'MainController@index',
        'as'  =>'main'
    ]);
    //notif
    Route::get('notif', [
        'uses'=>'MainController@notif',
        'as'  =>'notif'
    ]);
});

Route::group(['middleware'=>'auth', 'prefix'=>'nasabah'], function () {
    Route::get('/', [
        'uses' => 'NasabahController@index',
        'as'   => 'nasabah'
    ]);
    Route::get('data/{id}', [
        'uses' => 'NasabahController@show',
        'as'   => 'nasabah.data'
    ]);
    Route::post('tambah', [
        'uses' => 'NasabahController@store',
        'as'   => 'nasabah.tambah'
    ]);
    Route::put('ubah/{id}', [
        'uses' => 'NasabahController@update',
        'as'   => 'nasabah.ubah'
    ]);
    Route::post('hapus/{id}', [
        'uses' => 'NasabahController@destroy',
        'as'   => 'nasabah.hapus'
    ]);
    Route::get('lihat/{id}', [
        'uses' => 'NasabahController@lihatdetail',
        'as'   => 'nasabah.lihatdetail'
    ]);
});

Route::group(['middleware'=>'auth', 'prefix'=>'koperasi'], function () {
    Route::get('/', [
        'uses' => 'KoperasiController@index',
        'as'   => 'koperasi'
    ]);
    Route::get('data/{id}', [
        'uses' => 'KoperasiController@show',
        'as'   => 'koperasi.data'
    ]);
    Route::post('tambah', [
        'uses' => 'KoperasiController@store',
        'as'   => 'koperasi.tambah'
    ]);
    Route::put('ubah/{id}', [
        'uses' => 'KoperasiController@update',
        'as'   => 'koperasi.ubah'
    ]);
    Route::post('hapus/{id}', [
        'uses' => 'KoperasiController@destroy',
        'as'   => 'koperasi.hapus'
    ]);
});

Route::group(['middleware'=>'auth', 'prefix'=>'pegawai'], function () {
    Route::get('/', [
        'uses' => 'PegawaiController@index',
        'as'   => 'pegawai'
    ]);
    Route::get('data/{id}', [
        'uses' => 'PegawaiController@show',
        'as'   => 'pegawai.data'
    ]);
    Route::post('tambah', [
        'uses' => 'PegawaiController@store',
        'as'   => 'pegawai.tambah'
    ]);
    Route::put('ubah/{id}', [
        'uses' => 'PegawaiController@update',
        'as'   => 'pegawai.ubah'
    ]);
    Route::post('hapus/{id}', [
        'uses' => 'PegawaiController@destroy',
        'as'   => 'pegawai.hapus'
    ]);
});

Route::group(['middleware'=>'auth', 'prefix'=>'laporan'], function () {
    Route::get('/', [
        'uses' => 'PegawaiController@index',
        'as'   => 'laporan'
    ]);
    Route::get('data', [
        'uses' => 'PegawaiController@show',
        'as'   => 'laporan.data'
    ]);
});

Route::group(['middleware'=>'auth', 'prefix'=>'transaksi'], function () {
    Route::get('/', [
        'uses' => 'TransaksiController@index',
        'as'   => 'transaksi'
    ]);
    Route::get('cekuidnis',[
        'uses' => 'TransaksiController@CekUidNis',
        'as'   => 'cekuidnis'
    ]);
    Route::get('data', [
        'uses' => 'TransaksiController@show',
        'as'   => 'transaksi.data'
    ]);
    Route::post('simpan', [
        'uses' => 'TransaksiController@simpan',
        'as'   => 'transaksi.simpan'
    ]);
    Route::post('tarik', [
        'uses' => 'TransaksiController@tarik',
        'as'   => 'transaksi.tarik'
    ]);
    Route::post('belanja', [
        'uses' => 'TransaksiController@belanja',
        'as'   => 'transaksi.belanja'
    ]);
});
