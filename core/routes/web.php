<?php
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
Route::get('/coba', function () {
    Session::forget('step1');
});

Route::get('/', 'Auth\LoginController@showLoginForm');
Auth::routes();
Route::match(['get', 'post'], '/pengaturan', 'UserController@pengaturan')->name('pengaturan');
Route::post('/ubah_pw','UserController@ubah_pw')->name('ubah_pw');

Route::get('/beranda', 'BerandaController@index')->name('beranda');

Route::group(['prefix' => '/jalan'], function () {
    Route::get('/','JalanController@index')->name('jalan');
    Route::match(['get', 'post'], 'tambah', 'JalanController@tambah')->name('jalan.tambah');
    Route::get('/detail/{id}','JalanController@detail')->name('jalan.detail');
    Route::post('/simpan','JalanController@simpan')->name('jalan.simpan');
    Route::post('/penganggaran','JalanController@penganggaran')->name('jalan.penganggaran');
    Route::get('/edit/{id}','JalanController@edit')->name('jalan.edit');
    Route::post('/update','JalanController@update')->name('jalan.update');
    Route::get('/hapus/{id}','JalanController@hapus')->name('jalan.hapus');


    Route::group(['prefix' => '/{id}/penganggaran'], function () {
        Route::get('jalan/','PenganggaranController@jalan')->name('penganggaran.jalan');
        Route::match(['get', 'post'], '/langkah-1', 'PenganggaranController@step1')->name('penganggaran.tambah');
        Route::match(['get', 'post'], '/langkah-2', 'PenganggaranController@step2')->name('penganggaran.step2');
        Route::match(['get', 'post'], '/langkah-3', 'PenganggaranController@step3')->name('penganggaran.step3');
    });

});

Route::group(['prefix' => '/tpt'], function () {
    // Route::get('/','TPTController@index')->name('tpt');
    Route::get('/{jalan_id}','TPTController@index')->name('tpt');
    Route::match(['get', 'post'], 'tambah/{jalan_id}', 'TPTController@tambah')->name('tpt.tambah');
    Route::get('/detail/{id}','TPTController@detail')->name('tpt.detail');
    Route::post('/simpan','TPTController@simpan')->name('tpt.simpan');
    Route::get('/edit/{id}','TPTController@edit')->name('tpt.edit');
    Route::post('/update','TPTController@update')->name('tpt.update');
    Route::get('/hapus/{id}','TPTController@hapus')->name('tpt.hapus');
    Route::post('/penganggaran','TPTController@penganggaran')->name('tpt.penganggaran');
});

Route::group(['prefix' => '/drainase'], function () {
    Route::get('/{jalan_id}','DrainaseController@index')->name('drainase');
    Route::get('/tambah/{id}','DrainaseController@tambah')->name('drainase.tambah');
    Route::get('/detail/{id}','DrainaseController@detail')->name('drainase.detail');
    Route::post('/simpan','DrainaseController@simpan')->name('drainase.simpan');
    Route::post('/penganggaran','DrainaseController@penganggaran')->name('drainase.penganggaran');
    Route::get('/edit/{id}','DrainaseController@edit')->name('drainase.edit');
    Route::post('/update','DrainaseController@update')->name('drainase.update');
    Route::get('/hapus/{id}','DrainaseController@hapus')->name('drainase.hapus');
});

Route::group(['prefix' => '/beton'], function () {
    Route::get('/{jalan_id}','BetonController@index')->name('beton');
    Route::get('/tambah/{id}','BetonController@tambah')->name('beton.tambah');
    Route::get('/detail/{id}','BetonController@detail')->name('beton.detail');
    Route::post('/simpan','BetonController@simpan')->name('beton.simpan');
    Route::get('/edit/{id}','BetonController@edit')->name('beton.edit');
    Route::post('/update','BetonController@update')->name('beton.update');
    Route::get('/hapus/{id}','BetonController@hapus')->name('beton.hapus');
    Route::post('/penganggaran','BetonController@penganggaran')->name('beton.penganggaran');
});

Route::group(['prefix' => '/jembatan'], function () {
    Route::get('/{id}','JembatanController@index')->name('jembatan');
    Route::get('/tambah/{id}','JembatanController@tambah')->name('jembatan.tambah');
    Route::get('/detail/{id}','JembatanController@detail')->name('jembatan.detail');
    Route::post('/simpan','JembatanController@simpan')->name('jembatan.simpan');
    Route::post('/penganggaran','JembatanController@penganggaran')->name('jembatan.penganggaran');
    Route::get('/edit/{id}','JembatanController@edit')->name('jembatan.edit');
    Route::post('/update','JembatanController@update')->name('jembatan.update');
    Route::get('/hapus/{id}','JembatanController@hapus')->name('jembatan.hapus');
});

Route::group(['prefix' => '/penganggaran'], function () {
    Route::get('/','PenganggaranController@index')->name('penganggaran');
    Route::get('/{id}','PenganggaranController@data')->name('penganggaran.data');
    Route::get('jalan/{id}','PenganggaranController@jalan')->name('penganggaran.jalan');
    // Route::get('/tambah/{id}','PenganggaranController@tambah')->name('penganggaran.tambah');
    // Route::match(['get', 'post'], '/{id}/langkah-1', 'PenganggaranController@step1')->name('penganggaran.tambah');
    // Route::match(['get', 'post'], '/{id}/langkah-2', 'PenganggaranController@step2')->name('penganggaran.step2');
    // Route::match(['get', 'post'], '/{id}/langkah-3', 'PenganggaranController@step3')->name('penganggaran.step3');
    Route::get('/detail/{id}','PenganggaranController@detail')->name('penganggaran.detail');
    Route::post('/simpan','PenganggaranController@simpan')->name('penganggaran.simpan');
    Route::get('/edit/{id}','PenganggaranController@edit')->name('penganggaran.edit');
    Route::post('/update','PenganggaranController@update')->name('penganggaran.update');
    Route::get('/hapus/{id}','PenganggaranController@hapus')->name('penganggaran.hapus');
    Route::post('/json/{id}','PenganggaranController@json')->name('penganggaran.json');
    Route::post('/upload-file','PenganggaranController@file_upload')->name('penganggaran.file_upload');
    Route::post('/hapus-file','PenganggaranController@hapus_file')->name('penganggaran.hapus_file');


});

Route::group(['prefix' => '/njop'], function () {
    Route::get('/','NJOPController@index')->name('njop');
    Route::get('/detail/{id}','NJOPController@detail')->name('njop.detail');
    Route::post('/simpan','NJOPController@simpan')->name('njop.simpan');
    Route::get('/edit/{id}','NJOPController@edit')->name('njop.edit');
    Route::post('/update','NJOPController@update')->name('njop.update');
    Route::get('/hapus/{id}','NJOPController@hapus')->name('njop.hapus');
});

Route::group(['prefix' => '/pengguna'], function () {
    Route::get('/','UserController@index')->name('pengguna');
    Route::post('/simpan','UserController@simpan')->name('pengguna.simpan');
    Route::get('/edit/{id}','UserController@edit')->name('pengguna.edit');
    Route::post('/update','UserController@update')->name('pengguna.update');
    Route::get('/hapus/{id}','UserController@hapus')->name('pengguna.hapus');
});
