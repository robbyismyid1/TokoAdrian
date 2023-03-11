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

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'DashboardController@index')->name(
        'dashboard'
    );

    Route::get('/laporan/penjualan', 'DashboardController@pdf_penjualan')->name(
        'report_sales'
    );

    Route::get('/laporan/pembelian', 'DashboardController@pdf_pembelian')->name(
        'report_purchases'
    );

    Route::get('/403', function () {
        return view('errors.403');
    });
    
    Route::resource('/karyawan', 'ModeratorController')->except([
        'show'
    ]);
    Route::get('/karyawan/profile', 'ModeratorController@profile')->name(
        'karyawan.profile'
    );

    Route::resource('/kategori', 'KategoriController')->except([
        'show'
    ]);
    
    Route::resource('/produk', 'ProdukController')->except([
        'show'
    ]);
    Route::get('/searchsale', ['uses' => 'ProdukController@searchsale', 'as' => 'produk.searchsale']);
    Route::get('/searchpurchase', ['uses' => 'ProdukController@searchpurchase', 'as' => 'produk.searchpurchase']);
    Route::put('/updateprice/{id}', 'ProdukController@updateprice')->name('produk.updateprice');
    
    Route::resource('/klien', 'KlienController')->except([
        'show'
    ]);
    Route::get('/klien/detail/{id}', 'KlienController@detailpenjualan')->name('klien.detail');
    Route::post('/createinsale', 'KlienController@createinsale')->name('klien.storeinsale');
    
    Route::resource('/pemasok', 'PemasokController')->except([
        'show'
    ]);
    Route::get('/pemasok/detail/{id}', 'PemasokController@detailpembelian')->name('pemasok.detail');
    
    Route::resource('/penjualan', 'PenjualanController');
    Route::put('/hutangklien/{id}', 'PenjualanController@hutangklien')->name('penjualan.hutangklien');

    Route::resource('/pembelian', 'PembelianController');
    Route::put('/hutangsaya/{id}', 'PembelianController@hutangsaya')->name('pembelian.hutangsaya');

    Route::resource('/pengeluaran', 'PengeluaranController')->except([
        'show'
    ]);

    Route::get('/kotakuang', 'KotakUangController@index')->name('kotakuang.index');
    
    Route::resource('/pengaturan', 'GeneralSettingController')->except([
        'show', 'update', 'destroy', 'create', 'edit'
    ]);
});
