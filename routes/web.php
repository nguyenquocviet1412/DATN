<?php

use App\Http\Controllers\admin\AdminController;
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
    return view('welcome');
});


// ----------------------------------------------------------------
//Route Admin
Route::get('/test', [AdminController::class,'index'])->name('test');
    //route product
    Route::prefix('product')->group(function () {
        Route::get('/', [AdminController::class,'productIndex'])->name('product.index');
        Route::get('/create', [AdminController::class,'productCreate'])->name('product.create');
        Route::post('/store', [AdminController::class,'productStore'])->name('product.store');
        Route::get('/edit/{id}', [AdminController::class,'productEdit'])->name('product.edit');
        Route::put('/update/{id}', [AdminController::class,'productUpdate'])->name('product.update');
        Route::delete('/delete/{id}', [AdminController::class,'productDelete'])->name('product.delete');
    });
