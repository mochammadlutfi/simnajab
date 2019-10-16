<?php
use Spatie\Permission\Models\Role;
Route::get('/coba', function () {

    $ar[1]['parent']=0;
    $ar[1]['value']=1;
    $ar[1]['nama']='Agus';
    $ar[1]['posisi']='Ketua';

    $ar[2]['parent']=1;
    $ar[2]['value']=2;
    $ar[2]['nama']='Novan';
    $ar[2]['posisi']='Wakil 1';

    $ar[3]['parent']=1;
    $ar[3]['value']=3;
    $ar[3]['nama']='Budi';
    $ar[3]['posisi']='Wakil 2';

    $ar[4]['parent']=2;
    $ar[4]['value']=4;
    $ar[4]['nama']='Syauqil';
    $ar[4]['posisi']='Anggota';

    $ar[5]['parent']=2;
    $ar[5]['value']=5;
    $ar[5]['nama']='Aji';
    $ar[5]['posisi']='Anggota';

    $ar[6]['parent']=3;
    $ar[6]['value']=6;
    $ar[6]['nama']='Wildan';
    $ar[6]['posisi']='Anggota';

    $ar[7]['parent']=3;
    $ar[7]['value']=7;
    $ar[7]['nama']='Ni\'am';
    $ar[7]['posisi']='Anggota';

    $ar[8]['parent']=3;
    $ar[8]['value']=8;
    $ar[8]['nama']='Bayu';
    $ar[8]['posisi']='Anggota';

    $ar[9]['parent']=8;
    $ar[9]['value']=9;
    $ar[9]['nama']='Bayu';
    $ar[9]['posisi']='Anak Buah BAyu';

function dfs($arr,$parent,$base){
 global $explc;
 global $explv;
 $explc++;

 for($a=1; $a<=count($arr); $a++){
    // dd($arr[$a]['parent']);
  if($parent==0){
   $explv[$explc]['parent'] = $arr[$a]['parent'];
   $explv[$explc]['value'] = $arr[$a]['value'];
   $explv[$explc]['nama'] = $arr[$a]['nama'];
   $explv[$explc]['posisi'] = $arr[$a]['posisi'];

   $explv[$explc]['base'] = $base;
  }
  if($arr[$a]['parent']==$parent){
    $explv[$explc]['parent'] = $arr[$a]['parent'];
    $explv[$explc]['value'] = $arr[$a]['value'];
    $explv[$explc]['nama'] = $arr[$a]['nama'];
    $explv[$explc]['posisi'] = $arr[$a]['posisi'];

    $explv[$explc]['base'] = $base;
    $base++;
    dfs($arr,$arr[$a]['value'],$base);
    $base--;
  }
 }
}

function menjorok($jumlah,$tanda){
 for($a=0;$a<$jumlah;$a++) echo $tanda;
}

echo "\n";
global $explv,$explc;
$explc = -1;
// dd($ar);
dfs($ar,5,0);
dd($explv);
for($a=0; $a<$explc; $a++){
 echo menjorok($explv[$a]['base'],' - ').$explv[$a]['nama']." (".$explv[$a]['posisi'].")<br>";
}
unset($explc);
unset($explv);
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
    Route::get('/edit/{id}','JalanController@edit')->name('jalan.edit');
    Route::post('/update','JalanController@update')->name('jalan.update');
    Route::get('/hapus/{id}','JalanController@hapus')->name('jalan.hapus');
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
});

Route::group(['prefix' => '/drainase'], function () {
    Route::get('/{jalan_id}','DrainaseController@index')->name('drainase');
    Route::get('/tambah/{id}','DrainaseController@tambah')->name('drainase.tambah');
    Route::get('/detail/{id}','DrainaseController@detail')->name('drainase.detail');
    Route::post('/simpan','DrainaseController@simpan')->name('drainase.simpan');
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
});

Route::group(['prefix' => '/jembatan'], function () {
    Route::get('/{id}','JembatanController@index')->name('jembatan');
    Route::get('/tambah/{id}','JembatanController@tambah')->name('jembatan.tambah');
    Route::get('/detail/{id}','JembatanController@detail')->name('jembatan.detail');
    Route::post('/simpan','JembatanController@simpan')->name('jembatan.simpan');
    Route::get('/edit/{id}','JembatanController@edit')->name('jembatan.edit');
    Route::post('/update','JembatanController@update')->name('jembatan.update');
    Route::get('/hapus/{id}','JembatanController@hapus')->name('jembatan.hapus');
});

Route::group(['prefix' => '/penganggaran'], function () {
    Route::get('/','PenganggaranController@index')->name('penganggaran');
    Route::get('jalan/{id}','PenganggaranController@jalan')->name('penganggaran.jalan');
    // Route::get('/tambah/{id}','PenganggaranController@tambah')->name('penganggaran.tambah');
    Route::match(['get', 'post'], '/{id}/langkah-1', 'PenganggaranController@step1')->name('penganggaran.tambah');
    Route::match(['get', 'post'], '/{id}/langkah-2', 'PenganggaranController@step2')->name('penganggaran.step2');
    Route::match(['get', 'post'], '/{id}/langkah-3', 'PenganggaranController@step3')->name('penganggaran.step3');
    Route::get('/detail/{id}','PenganggaranController@detail')->name('penganggaran.detail');
    Route::post('/simpan','PenganggaranController@simpan')->name('penganggaran.simpan');
    Route::get('/edit/{id}','PenganggaranController@edit')->name('penganggaran.edit');
    Route::post('/update','PenganggaranController@update')->name('penganggaran.update');
    Route::get('/hapus/{id}','PenganggaranController@hapus')->name('penganggaran.hapus');
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
