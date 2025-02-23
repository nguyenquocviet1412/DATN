<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\admin\EmployeeController;
use App\Http\Controllers\admin\VoucherController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\admin\RateController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\VariantConntroller;
use App\Models\Employee;
use App\Models\User;
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
Route::prefix('admin')->group(function () {
    //route product
    Route::prefix('product')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    });
    //route variant
    Route::prefix('variant')->group(function () {
        Route::get('/', [VariantConntroller::class, 'variantIndex'])->name('variant.index');
        Route::get('/create/{id}', [VariantConntroller::class, 'variantCreate'])->name('variant.create');
        Route::post('/store/{id}', [VariantConntroller::class, 'variantStore'])->name('variant.store');
        Route::get('/edit/{id}', [VariantConntroller::class, 'variantEdit'])->name('variant.edit');
        Route::put('/update/{id}', [VariantConntroller::class, 'variantUpdate'])->name('variant.update');
        Route::delete('/delete/{id}', [VariantConntroller::class, 'variantDelete'])->name('variant.delete');
        Route::delete('/variant/image/{id}', [VariantConntroller::class, 'deleteImage'])->name('variant.image.delete');

    });

    //route voucher
    Route::prefix('voucher')->group(function () {
        Route::get('/', [VoucherController::class, 'voucherIndex'])->name('voucher.index');
Route::get('/create', [VoucherController::class, 'voucherCreate'])->name('voucher.create');
        Route::post('/store', [VoucherController::class, 'voucherStore'])->name('voucher.store');
        Route::get('/edit/{id}', [VoucherController::class, 'voucherEdit'])->name('voucher.edit');
        Route::put('/update/{id}', [VoucherController::class, 'voucherUpdate'])->name('voucher.update');
        Route::delete('/delete/{id}', [VoucherController::class, 'voucherDelete'])->name('voucher.delete');

        Route::post('/toggle-status/{id}', [VoucherController::class, 'toggleStatus'])->name('voucher.toggleStatus');
    });

    //route Category
    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'categoryIndex'])->name('category.index');
        Route::get('/create', [CategoryController::class, 'categoryCreate'])->name('category.create');
        Route::post('/store', [CategoryController::class, 'categoryStore'])->name('category.store');
        Route::get('/edit/{id}', [CategoryController::class, 'categoryEdit'])->name('category.edit');
        Route::put('/update/{id}', [CategoryController::class, 'categoryUpdate'])->name('category.update');
        Route::delete('/delete/{id}', [CategoryController::class, 'categoryDelete'])->name('category.delete');
    });

    //route Report
    Route::get('/report', [AdminReportController::class, 'index'])->name('admin.reports.index');

    //route Employee
    Route::prefix('employee')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::put('/update/{id}', [EmployeeController::class, 'update'])->name('employee.update');
        Route::get('/show/{id}', [EmployeeController::class, 'show'])->name('employee.show');
        Route::delete('/delete/{id}', [EmployeeController::class, 'delete'])->name('employee.delete');
    });

    //route User
    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
        Route::get('/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('user.show');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
    });
});


//route comment
Route::prefix('comment')->group(function () {
Route::get('/', [CommentController::class, 'indexCMT'])->name('comment.index');
    Route::get('/create', [CommentController::class, 'createCMT'])->name('comment.create');
    Route::post('/store', [CommentController::class, 'storeCMT'])->name('comment.store');
    Route::get('/edit/{id}', [CommentController::class,'editCMT'])->name('comment.edit');
    Route::put('/update/{id}', [CommentController::class, 'updateCMT'])->name('comment.update');
    Route::delete('/delete/{id}', [CommentController::class, 'destroyCMT'])->name('comment.destroy');
    Route::patch('/hide/{id}', [CommentController::class, 'hideCMT'])->name('comment.hide');
});

 //route rate
Route::prefix('rate')->group(function () {
    Route::get('/', [RateController::class, 'Rindex'])->name('rate.index');
    Route::get('/create', [RateController::class, 'Rcreate'])->name('rate.create');
    Route::post('/store', [RateController::class, 'Rstore'])->name('rate.store');
    Route::get('/edit/{id}', [RateController::class, 'Redit'])->name('rate.edit');
    Route::put('/update/{id}', [RateController::class, 'Rupdate'])->name('rate.update');
    Route::delete('/delete/{id}', [RateController::class, 'Rdestroy'])->name('rate.destroy');
});
// ROute order
Route::prefix('order')->group(function () {
    Route::get('/', [OrderController::class, 'orderIndex'])->name('order.index');

Route::get('/order/{id}/restore',[OrderController::class, 'restore'])->name('order.restore');
Route::get('/order/{id}/forceDelete',[OrderController::class, 'forceDelete'])->name('order.forceDelete');

Route::resource('order', OrderController::class);
});