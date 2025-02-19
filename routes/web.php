<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\VoucherController;
use App\Http\Controllers\HomeController;
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


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/login', [HomeController::class, 'login'])->name('home.login');
Route::get('/register', [HomeController::class, 'register'])->name('home.register');


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

    //route voucher
    Route::prefix('voucher')->group(function () {
        Route::get('/', [VoucherController::class,'voucherIndex'])->name('voucher.index');
        Route::get('/create', [VoucherController::class,'voucherCreate'])->name('voucher.create');
        Route::post('/store', [VoucherController::class,'voucherStore'])->name('voucher.store');
        Route::get('/edit/{id}', [VoucherController::class,'voucherEdit'])->name('voucher.edit');
        Route::put('/update/{id}', [VoucherController::class,'voucherUpdate'])->name('voucher.update');
        Route::delete('/delete/{id}', [VoucherController::class,'voucherDelete'])->name('voucher.delete');
    });

    //route Category
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class,'categoryIndex'])->name('category.index');
        Route::get('/create', [CategoryController::class,'categoryCreate'])->name('category.create');
        Route::post('/store', [CategoryController::class,'categoryStore'])->name('category.store');
        Route::get('/edit/{id}', [CategoryController::class,'categoryEdit'])->name('category.edit');
        Route::put('/update/{id}', [CategoryController::class,'categoryUpdate'])->name('category.update');
        Route::delete('/delete/{id}', [CategoryController::class,'categoryDelete'])->name('category.delete');
    });

    

