<?php

use App\Http\Controllers\admin\Wallet_Transaction;
use App\Http\Controllers\Admin\WalletController;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\PostController;
use App\Http\Controllers\admin\RateController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\CommentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\admin\VoucherController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\EmployeeController;
use App\Http\Controllers\admin\VariantConntroller;
use App\Http\Controllers\Admin\WalletTransactionController;
use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\admin\EmployeeAuthController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\client\DetailProductController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\FilterProductController;

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

// ------------------------------------------------------------------------------------------------------------------
// Route CLIENT
  // Routes đăng ký đăng nhập cho khách hàng
      Route::get('/login', [AuthController::class, 'getLogin'])->name('login');
      Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');
      Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');


      Route::get('/register', [AuthController::class, 'getRegister'])->name('register');
      Route::post('/register', [AuthController::class, 'postRegister'])->name('postRegister');

      Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

  //Route home
      Route::get('/', [HomeController::class, 'index'])->name('home.index');
      Route::get('/filter-product', [FilterProductController::class, 'index'])->name('filter-product');

  // chi tiết sản phẩm
      Route::get('/product/{id}', [DetailProductController::class, 'show'])->name('product.show');


  //Giỏ hàng
      Route::prefix('cart')->group(function () {
          Route::get('/', [CartController::class, 'index'])->name('cart.index'); // Hiển thị giỏ hàng
          Route::post('/store', [CartController::class, 'store'])->name('cart.store'); // Thêm sản phẩm vào giỏ hàng
          Route::put('/update/{id}', [CartController::class, 'update'])->name('cart.update'); // Cập nhật số lượng sản phẩm trong giỏ hàng
          Route::delete('/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy'); // Xóa sản phẩm khỏi giỏ hàng
          Route::post('/applyCoupon', [CartController::class, 'applyCoupon'])->name('cart.applyCoupon'); // Áp dụng mã giảm giá
      });







// -----------------------------------------------------------------------------------------------------------------------------------------
//Route ADMIN
// Routes đăng nhập cho nhân viên
Route::get('/admin/login', [EmployeeAuthController::class, 'getLogin'])->name('admin.login');
Route::post('/admin/login', [EmployeeAuthController::class, 'postLogin'])->name('admin.postLogin');
Route::get('/admin/logout', [EmployeeAuthController::class, 'logout'])->name('admin.logout');


Route::prefix('admin')->middleware(['employee.auth'])->group(function () {
    //route dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


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

        Route::delete('/delete/{id}', [CategoryController::class, 'categoryDelete'])->name('category.delete'); // Xóa mềm
        Route::get('/trash', [CategoryController::class, 'categoryTrash'])->name('category.trash'); // Danh mục đã xóa
        Route::get('/restore/{id}', [CategoryController::class, 'categoryRestore'])->name('category.restore'); // Khôi phục
        Route::delete('/force-delete/{id}', [CategoryController::class, 'categoryForceDelete'])->name('category.force-delete'); // Xóa vĩnh viễn

        Route::get('/edit/{id}', [CategoryController::class, 'categoryEdit'])->name('category.edit');
        Route::put('/update/{id}', [CategoryController::class, 'categoryUpdate'])->name('category.update');
    });

    //route Wallet
    Route::get('/wallets', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallets/{id}/toggle', [WalletController::class, 'toggleStatus'])->name('wallet.toggleStatus');

    //route Wallet_Transaction
    Route::get('admin/wallet/{id}/transactions', [Wallet_Transaction::class, 'show'])->name('wallet.transactions');

    /// Route quản lý Color
    Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('admin/color', ColorController::class);
    Route::get('/color', [ColorController::class, 'index'])->name('color.index');
    Route::get('/color/create', [ColorController::class, 'create'])->name('color.create');
    Route::post('/color/store', [ColorController::class, 'store'])->name('color.store');
    Route::get('/color/edit/{id}', [ColorController::class, 'edit'])->name('color.edit');
    Route::put('/color/update/{id}', [ColorController::class, 'update'])->name('color.update');
    Route::get('/colortrash', [ColorController::class, 'trash'])->name('color.trash');
    Route::get('/color/delete/{id}', [ColorController::class, 'softDelete'])->name('color.softDelete');
    Route::get('/color/restore/{id}', [ColorController::class, 'restore'])->name('color.restore');
    Route::delete('/color/destroy/{id}', [ColorController::class, 'destroy'])->name('color.destroy');
     });

    // Route quản lý Size
    Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('size', SizeController::class)->except(['show']);
    Route::get('/size', [SizeController::class, 'index'])->name('size.index');
    Route::get('/size/create', [SizeController::class, 'create'])->name('size.create');
    Route::post('/size/store', [SizeController::class, 'store'])->name('size.store');
    Route::get('/size/edit/{id}', [SizeController::class, 'edit'])->name('size.edit');
    Route::put('/size/update/{id}', [SizeController::class, 'update'])->name('size.update');
    Route::get('/size/trash', [SizeController::class, 'trash'])->name('size.trash');
    Route::get('/size/delete/{id}', [SizeController::class, 'softDelete'])->name('size.softDelete');
    Route::get('/size/restore/{id}', [SizeController::class, 'restore'])->name('size.restore');
    Route::delete('/size/destroy/{id}', [SizeController::class, 'destroy'])->name('size.destroy');
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
        Route::get('admin/employee/deleted', [EmployeeController::class, 'deleted'])->name('employee.deleted');
        Route::patch('admin/employee/restore/{id}', [EmployeeController::class, 'restore'])->name('employee.restore');
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
        Route::get('admin/user/deleted', [UserController::class, 'deleted'])->name('user.deleted');
        Route::patch('admin/user/restore/{id}', [UserController::class, 'restore'])->name('user.restore');
    });
    //route wallet_transactions
    Route::resource('wallet_transactions', WalletTransactionController::class);
    Route::get('wallet_transactions', [WalletTransactionController::class, 'index'])->name('admin.wallet_transactions.index');
    Route::get('admin/wallet_transactions/{id}', [WalletTransactionController::class, 'show'])->name('admin.wallet_transactions.show');
    Route::delete('admin/wallet_transactions/{id}', [WalletTransactionController::class, 'destroy'])->name('admin.wallet_transactions.destroy');

    //route comment
    Route::prefix('comment')->group(function () {
        Route::get('/', [CommentController::class, 'indexCMT'])->name('comment.index');
        Route::get('/create', [CommentController::class, 'createCMT'])->name('comment.create');
        Route::post('/store', [CommentController::class, 'storeCMT'])->name('comment.store');
        Route::get('/edit/{id}', [CommentController::class, 'editCMT'])->name('comment.edit');
        Route::put('/update/{id}', [CommentController::class, 'updateCMT'])->name('comment.update');
        Route::delete('/delete/{id}', [CommentController::class, 'destroyCMT'])->name('comment.destroy');
        Route::patch('/hide/{id}', [CommentController::class, 'hideCMT'])->name('comment.hide');
    });

//route rate
    Route::prefix('rate')->group(function () {
        Route::get('/', [RateController::class, 'Rindex'])->name('rate.index');
        Route::get('/{id_product}', [RateController::class, 'show'])->name('rate.show');
        Route::get('/create', [RateController::class, 'Rcreate'])->name('rate.create');
        Route::post('/store', [RateController::class, 'Rstore'])->name('rate.store');
        Route::get('/edit/{id}', [RateController::class, 'Redit'])->name('rate.edit');
        Route::put('/update/{id}', [RateController::class, 'Rupdate'])->name('rate.update');
        Route::delete('/delete/{id}', [RateController::class, 'Rdestroy'])->name('rate.destroy');
    });
// ROute order
    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::get('/{id}/restore', [OrderController::class, 'restore'])->name('order.restore');
        Route::get('/show/{id}', [OrderController::class, 'show'])->name('order.show');
        Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
        Route::put('/update/{id}', [OrderController::class, 'update'])->name('order.update');
        Route::delete('/delete/{id}', [OrderController::class, 'delete'])->name('order.delete');
    });
//route Post
    Route::prefix('post')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('post.index');
        Route::get('/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/store', [PostController::class, 'store'])->name('post.store');
        Route::get('/edit/{id}', [PostController::class, 'edit'])->name('post.edit');
        Route::put('/update/{id}', [PostController::class, 'update'])->name('post.update');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('post.show');
        Route::delete('/delete/{id}', [PostController::class, 'delete'])->name('post.delete');
    });

});





