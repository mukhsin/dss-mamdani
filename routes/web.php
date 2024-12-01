<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('welcome');

Route::view('profile', 'pages.profile')
    ->middleware(['auth'])
    ->name('profile');

Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::view('/dashboard', 'pages.dashboard')->name('dashboard');

    Volt::route('/diskon', 'diskon.index')->name('diskon.index');
    Volt::route('/diskon/create', 'diskon.create')->name('diskon.create');
    Volt::route('/diskon/{diskon_id}', 'diskon.show')->name('diskon.show');
    Volt::route('/diskon/{diskon_id}/edit', 'diskon.edit')->name('diskon.edit');

    Volt::route('/produk', 'produk.index')->name('produk.index');
    Volt::route('/produk/create', 'produk.create')->name('produk.create');
    Volt::route('/produk/{produk_id}', 'produk.show')->name('produk.show');
    Volt::route('/produk/{produk_id}/edit', 'produk.edit')->name('produk.edit');

    Volt::route('/penjualan', 'penjualan.index')->name('penjualan.index');
    Volt::route('/penjualan/create', 'penjualan.create')->name('penjualan.create');
    Volt::route('/penjualan/{penjualan_id}', 'penjualan.show')->name('penjualan.show');
    Volt::route('/penjualan/{penjualan_id}/edit', 'penjualan.edit')->name('penjualan.edit');

});
