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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/master-items', [App\Http\Controllers\MasterItemsController::class, 'index']);
Route::get('/master-items/search', [App\Http\Controllers\MasterItemsController::class, 'search']);
Route::get('/master-items/export-excel', [App\Http\Controllers\MasterItemsController::class, 'exportExcel']);
Route::get('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formView']);
Route::post('/master-items/form/{method}/{id?}', [App\Http\Controllers\MasterItemsController::class, 'formSubmit']);

Route::get('/master-items/view/{kode}', [App\Http\Controllers\MasterItemsController::class, 'singleView']);
Route::delete('/master-items/delete/{id}', [App\Http\Controllers\MasterItemsController::class, 'delete'])->name('master-items.delete');

use App\Http\Controllers\CategoryController;

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/search', [CategoryController::class, 'search']);
    Route::get('/form/{method}/{id?}', [CategoryController::class, 'formView']);
    Route::post('/form/{method}/{id?}', [CategoryController::class, 'formSubmit']);
    Route::get('/view/{id}', [CategoryController::class, 'singleView']);
    Route::get('/print-pdf/{id}', [CategoryController::class, 'printPDF']);
    Route::delete('/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');
});

Route::get('/master-items/update-random-data', [App\Http\Controllers\MasterItemsController::class, 'updateRandomData']);
