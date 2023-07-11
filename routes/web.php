<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReferenciasController;

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

Auth::routes();

Route::get('/', [ReferenciasController::class, 'index'])->name('busqueda');
Route::get('/buscarlc', [ReferenciasController::class, 'buscarlc'])->name('buscarlc');
Route::post('/update', [ReferenciasController::class, 'update'])->name('update');
Route::post('/insert', [ReferenciasController::class, 'Insertlc'])->name('insert');
Route::get('/tabla_bancos', [ReferenciasController::class, 'bancos'])->name('bancos');