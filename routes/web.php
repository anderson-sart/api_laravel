<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\HomeController;

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

Route::get('/antigo', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    // Adicione outras rotas protegidas aqui
        
    Route::get('/pedidos/imprimir-pdf/{id}', [SalesController::class, 'printPDF'])->name('sales.print.pdf');
    
    Route::get('/pedidos', [SalesController::class, 'list'])->name('sales.index');
});

//php artisan route:clear
//php artisan route:cache



