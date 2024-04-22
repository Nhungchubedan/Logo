<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;

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

Route::get('/', 'App\Http\Controllers\ProductController@home')->name('welcome');
Route::get('/search', 'App\Http\Controllers\ProductController@list')->name('search');
Route::get('/homepage', 'App\Http\Controllers\ProductController@list')->name('homepage');

Route::get('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout')->middleware('auth');
Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login');

Route::get('/forgot-password', 'App\Http\Controllers\AuthController@forgot')->name('password.forgot');
Route::post('/forgot-password', 'App\Http\Controllers\AuthController@forgot')->name('password.forgot');
Route::get('/reset-password/{token}', 'App\Http\Controllers\AuthController@reset')->name('password.reset');
Route::post('/reset-password/{token}', 'App\Http\Controllers\AuthController@reset')->name('password.reset');


Route::get('/register', 'App\Http\Controllers\AuthController@register')->name('register');
Route::post('/register', 'App\Http\Controllers\AuthController@register')->name('register');

Route::post('/ajax/sendotp', 'App\Http\Controllers\AuthController@sendOTP');


Route::get('/product/sortby', 'App\Http\Controllers\ProductController@list')->name('product.list');
Route::get('/product/{id}', 'App\Http\Controllers\ProductController@detail')->name('product.detail');
Route::post('/product/{id}', 'App\Http\Controllers\ProductController@detail')->name('product.detail');

Route::get('/brand', 'App\Http\Controllers\BrandController@list')->name('brand');

Route::get('/tai-khoan-cua-toi', 'App\Http\Controllers\AccountController@detail')->name('account')->middleware('auth');
Route::get('/tai-khoan-cua-toi/modify', 'App\Http\Controllers\AccountController@modify')->name('account.modify')->middleware('auth');
Route::post('/tai-khoan-cua-toi/modify', 'App\Http\Controllers\AccountController@modify')->name('account.modify')->middleware('auth');
Route::get('/tai-khoan-cua-toi/info', 'App\Http\Controllers\AccountController@info')->name('account.info')->middleware('auth');
Route::post('/tai-khoan-cua-toi/info', 'App\Http\Controllers\AccountController@info')->name('account.info')->middleware('auth');
Route::get('/tai-khoan-cua-toi/password', 'App\Http\Controllers\AccountController@password')->name('account.password')->middleware('auth');
Route::post('/tai-khoan-cua-toi/password', 'App\Http\Controllers\AccountController@password')->name('account.password')->middleware('auth');

Route::get('/don-hang', 'App\Http\Controllers\OrderController@detail')->name('order')->middleware('auth');
Route::post('/don-hang', 'App\Http\Controllers\OrderController@detail')->name('order')->middleware('auth');
Route::post('/don-hang/rate', 'App\Http\Controllers\OrderController@rate')->name('order.rate')->middleware('auth');
Route::get('/don-hang/detail/{id}', 'App\Http\Controllers\OrderController@orderdetail')->name('order.detail')->middleware('auth');

Route::get('/san-pham-yeu-thich', 'App\Http\Controllers\FavourController@detail')->name('favour')->middleware('auth');
Route::post('/san-pham-yeu-thich', 'App\Http\Controllers\FavourController@detail')->name('favour')->middleware('auth');
Route::delete('/san-pham-yeu-thich/{id}', 'App\Http\Controllers\FavourController@destroy')->name('favour.destroy')->middleware('auth');

Route::get('/gio-hang', 'App\Http\Controllers\CartController@detail')->name('cart')->middleware('auth');
Route::post('/gio-hang', 'App\Http\Controllers\CartController@detail')->name('cart')->middleware('auth');
Route::delete('/gio-hang/{id}', 'App\Http\Controllers\CartController@destroy')->name('cart.destroy')->middleware('auth');

Route::post('/order', 'App\Http\Controllers\OrderController@order')->name('order.order')->middleware('auth');
Route::get('/order', 'App\Http\Controllers\OrderController@order')->name('order.order')->middleware('auth');

Route::post('/order/pay', 'App\Http\Controllers\PaymentController@pay')->name('order.pay')->middleware('auth');
Route::post('/order/confirmPay', 'App\Http\Controllers\PaymentController@confirmPay')->middleware('auth');
Route::post('/order/cancelOrder', 'App\Http\Controllers\PaymentController@cancelOrder')->middleware('auth');

Route::post('/ajax/search', 'App\Http\Controllers\ProductController@getSearch');
Route::post('/api/fetch-districts', 'App\Http\Controllers\DropDownController@fetchDistricts');
Route::post('/api/fetch-communes', 'App\Http\Controllers\DropDownController@fetchCommunes');
Route::post('/generate-pdf', 'App\Http\Controllers\PDFController@generatePDF')->name('generate.pdf');

Route::get('auth/google', 'App\Http\Controllers\AuthController@redirectToGoogle')->name('google');
Route::get('auth/google/callback', 'App\Http\Controllers\AuthController@handleGoogleCallback');

Route::get('facebook/redirect', 'App\Http\Controllers\AuthController@redirectToFacebook')->name('facebook');
Route::get('facebook/callback', 'App\Http\Controllers\AuthController@handleFacebookCallback');

// ADMIN

/* 
index (GET)             show (GET)                  store (POST)            update (PUT)                destroy (DELETE)
URL: /resourceName      URL: /resourceName/{id}     URL: /resourceName      URL: /resourceName/{id}     URL: /resourceName/{id}
*/

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {
    Route::resource('product', ProductController::class, ['names' => 'product'])->middleware('checkRole:Admin,Staff,Editor');
    Route::resource('order', OrderController::class, ['names' => 'order'])->middleware('checkRole:Admin,Staff,Manager');
    Route::resource('category', CategoryController::class, ['names' => 'category'])->middleware('checkRole:Admin,Editor');
    Route::resource('account', AccountController::class, ['names' => 'account'])->middleware('checkRole:Admin');
    Route::resource('voucher', VoucherController::class, ['names' => 'voucher'])->middleware('checkRole:Admin,Staff');
    Route::resource('report', ReportController::class, ['names' => 'report'])->middleware('checkRole:Admin,Manager');
    Route::resource('payment', PaymentController::class, ['names' => 'payment'])->middleware('checkRole:Admin,Staff');
    Route::resource('rating', RatingController::class, ['names' => 'rating'])->middleware('checkRole:Admin,Staff');
    Route::resource('brand', BrandController::class, ['names' => 'brand'])->middleware('checkRole:Admin,Editor');

    Route::get('setting',[AccountController::class, 'setting'])->name('setting')->middleware('checkRole:Admin,Staff,Editor,Manager');
    Route::get('setting/modify',[AccountController::class, 'adminModify'])->name('modify')->middleware('checkRole:Admin,Staff,Editor,Manager');
    Route::post('setting/modify',[AccountController::class, 'adminModify'])->name('modify')->middleware('checkRole:Admin,Staff,Editor,Manager');
    Route::get('setting/password',[AccountController::class, 'adminPassword'])->name('password')->middleware('checkRole:Admin,Staff,Editor,Manager');
    Route::post('setting/password',[AccountController::class, 'adminPassword'])->name('password')->middleware('checkRole:Admin,Staff,Editor,Manager');

    Route::get('home', [AdminController::class, 'index'])->name('home')->middleware('checkRole:Admin,Staff,Editor,Manager');
    Route::get('report/export/{year}/{month}', [ReportController::class, 'export'])->name('report.export')->middleware('checkRole:Admin,Manager');
});

?>



