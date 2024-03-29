<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', [\App\Http\Controllers\Member\HomepageController::class, 'index']);
Route::match(['post', 'get'], '/login-member', [\App\Http\Controllers\AuthController::class, 'login_member']);
Route::match(['post', 'get'], '/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::match(['post', 'get'], '/login-admin', [\App\Http\Controllers\AuthController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index']);


Route::get('/product/{id}/detail', [\App\Http\Controllers\Member\HomepageController::class, 'product_page']);
Route::get('/product/data', [\App\Http\Controllers\Member\ProductController::class, 'get_product_by_name']);
Route::get('/kategori/{id}', [\App\Http\Controllers\Member\HomepageController::class, 'category_page']);
Route::get('/kategori/{id}/data', [\App\Http\Controllers\Member\HomepageController::class, 'get_product_by_name_and_category']);
Route::get('/about', [\App\Http\Controllers\Member\HomepageController::class, 'about_page']);
Route::get('/contact', [\App\Http\Controllers\Member\HomepageController::class, 'contact_page']);

Route::group(['prefix' => 'admin'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\AdminController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\AdminController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\AdminController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\AdminController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\AdminController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\AdminController::class, 'destroy']);
});

Route::group(['prefix' => 'member'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\MemberController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\MemberController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\MemberController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\MemberController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\MemberController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\MemberController::class, 'destroy']);
});

Route::group(['prefix' => 'category'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\CategoryController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\CategoryController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\CategoryController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\CategoryController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\CategoryController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'barang'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\BarangController::class, 'index']);
    Route::get( '/tambah', [\App\Http\Controllers\Admin\BarangController::class, 'add_page']);
    Route::post( '/create', [\App\Http\Controllers\Admin\BarangController::class, 'create']);
    Route::get( '/edit/{id}', [\App\Http\Controllers\Admin\BarangController::class, 'edit_page']);
    Route::post( '/patch', [\App\Http\Controllers\Admin\BarangController::class, 'patch']);
    Route::post( '/delete', [\App\Http\Controllers\Admin\BarangController::class, 'destroy']);
});

Route::match(['post', 'get'], '/denda', [\App\Http\Controllers\Admin\DendaController::class, 'index']);
Route::group(['prefix' => 'pesanan'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\TransaksiController::class, 'pesanan']);
    Route::match(['get', 'post'], '/{id}', [\App\Http\Controllers\Admin\TransaksiController::class, 'pesanan_detail']);
});

Route::group(['prefix' => 'pengambilan'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\TransaksiController::class, 'pengambilan']);
    Route::match(['get', 'post'], '/{id}', [\App\Http\Controllers\Admin\TransaksiController::class, 'pengambilan_detail']);
});

Route::group(['prefix' => 'pengembalian'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\TransaksiController::class, 'pengembalian']);
    Route::match(['get', 'post'], '/{id}', [\App\Http\Controllers\Admin\TransaksiController::class, 'pengembalian_detail']);
});

Route::group(['prefix' => 'pesanan-selesai'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\TransaksiController::class, 'pesanan_selesai']);
    Route::match(['get', 'post'], '/{id}', [\App\Http\Controllers\Admin\TransaksiController::class, 'pesanan_selesai_detail']);
    Route::get( '/{id}/cetak', [\App\Http\Controllers\Admin\TransaksiController::class, 'pesanan_selesai_cetak']);
});

Route::group(['prefix' => 'laporan-penyewaan'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_penyewaan']);
    Route::get( '/data', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_penyewaan_data']);
    Route::get( '/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_penyewaan_cetak']);
});

Route::group(['prefix' => 'laporan-barang-terlaris'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_barang_terlaris']);
    Route::get( '/data', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_barang_terlaris_data']);
    Route::get( '/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_barang_terlaris_cetak']);
});

Route::group(['prefix' => 'laporan-stock'], function () {
    Route::get( '/', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_stock']);
    Route::get( '/data', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_stock_data']);
    Route::get( '/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'laporan_stock_cetak']);
});

Route::group(['prefix' => 'keranjang'], function () {
    Route::get( '/', [\App\Http\Controllers\Member\KeranjangController::class, 'index']);
    Route::post( '/create', [\App\Http\Controllers\Member\KeranjangController::class, 'add_to_cart']);
    Route::post( '/checkout', [\App\Http\Controllers\Member\KeranjangController::class, 'checkout']);
    Route::get( '/count', [\App\Http\Controllers\Member\KeranjangController::class, 'count_cart']);
    Route::post( '/destroy', [\App\Http\Controllers\Member\KeranjangController::class, 'delete_cart']);
});

Route::group(['prefix' => 'transaksi'], function () {
    Route::get( '/', [\App\Http\Controllers\Member\TransaksiController::class, 'index']);
    Route::get( '/{id}/detail', [\App\Http\Controllers\Member\TransaksiController::class, 'detail']);
    Route::get( '/{id}/cetak', [\App\Http\Controllers\Member\TransaksiController::class, 'cetak_nota']);
    Route::match(['post', 'get'], '/{id}/pembayaran', [\App\Http\Controllers\Member\TransaksiController::class, 'pembayaran']);
});

