<?php

use App\Http\Controllers\DownloadInvoiceController;
use App\Models\Store;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $store = Store::all()->first();
    return view('welcome', compact('store'));
});

Route::get('invoice-download/{invoice}', [DownloadInvoiceController::class, 'download'])->name('invoices.download');
Route::get('invoice-print/{invoice}', [DownloadInvoiceController::class, 'print'])->name('invoices.print');

// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
