<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BorrowProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\EventDetailController;
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
    return view('frontend.authentication.auth_login');
});

// All Custom Auth Routes
Route::controller(CustomAuthController::class)->group(function (){
    Route::get('/login','index')->name('login');
    Route::get('/logout', 'Logout')->name('logout');
    Route::get('/registration','registration')->name('register-user');
    Route::post('/customRegistration','customRegistration')->name('register.custom');
    Route::post('/customLogin','customLogin')->name('customLogin');

});

Route::group(['middleware' => 'user_check:manager:admin'], function (){


    // All Dashboard Routes
    Route::controller(DashboardController::class)->group(function (){
        Route::get('/admin','index')->name('admin');

    });

    // Auth Routes
    Route::get('logout',[CustomAuthController::class, 'Logout'])->name('logout');

    // All Category Routes
    Route::controller(CategoryController::class)->group(function (){
        Route::get('/category','index')->name('category');
        Route::get('/add/category','AddCategory')->name('add.category');
        Route::post('/store/category','StoreCategory')->name('store.category');
        Route::get('/edit/category/{id}','EditCategory')->name('edit.category');
        Route::post('/update/category/{id}','UpdateCategory')->name('update.category');
        Route::get('/delete/category/{id}','DeleteCategory')->name('delete.category');

    });

    // All Author Routes
    Route::controller(AuthorController::class)->group(function (){
        Route::get('/author','index')->name('author');
        Route::get('/add/author','AddAuthor')->name('add.author');
        Route::post('/store/author','StoreAuthor')->name('store.author');
        Route::get('/edit/author/{id}','EditAuthor')->name('edit.author');
        Route::post('/update/author/{id}','UpdateAuthor')->name('update.author');
        Route::get('/delete/author/{id}','DeleteAuthor')->name('delete.author');

    });

    // All Product Routes
    Route::controller(ProductController::class)->group(function (){
        Route::get('/product','index')->name('product');
        Route::get('/add/product','AddProduct')->name('add.product');
        Route::post('/store/product','StoreProduct')->name('store.product');
        Route::get('/edit/product/{id}','EditProduct')->name('edit.product');
        Route::post('/update/product/{id}','UpdateProduct')->name('update.product');
        Route::post('/filter/product','ProductFilter')->name('filter.product');
//   Route::get('/delete/product/{id}','DeleteProduct')->name('delete.product');

    });

    // All Events Routes
    Route::controller(EventController::class)->group(function (){
        Route::get('/Events','Events')->name('Events');
        Route::get('/CreateEvents','CreateEvents')->name('CreateEvents');
        Route::post('/StoreEvent','StoreEvent')->name('store.event');
        Route::get('/Edit/Event/{id}','EditEvent')->name('edit.event');
        Route::post('/Update/Event/{id}','UpdateEvent')->name('update.event');
        Route::get('/Delete/Event/{id}','DeleteEvent')->name('delete.event');

    });

    // All Orders Routes
    Route::controller(OrdersController::class)->group(function (){
       Route::get('/GetOrders', 'GetOrders')->name('GetOrders');
       Route::post('AdminExtendTime/{id}', 'AdminExtendTime')->name('AdminExtendTime');
       Route::post('AdminReceiveProduct/{id}', 'AdminReceiveProduct')->name('AdminReceiveProduct');

    });

});


Route::group(['middleware' => 'user_check:user'], function (){

    // Auth Routes
    Route::get('/library', [CustomAuthController::class, 'Library'])->name('library');

    // User Routes
    Route::get('MyInformation', [UserController::class, 'my_information'])->name('my_information');
    Route::post('Add_address', [UserController::class, 'AddAddress'])->name('add_address');
    Route::get('/delete/address/{id}',[UserController::class, 'DeleteAddress'])->name('delete.address');
    Route::get('/Orders',[UserController::class, 'Orders'])->name('Orders');

    // Product Detail
    Route::controller(ProductDetailController::class)->group(function (){
        Route::get('/product/detail/{id}', 'ShowProduct')->name('product-detail');
    });

    // All Borrow Product
    Route::controller(BorrowProductController::class)->group(function (){
        Route::post('/borrow/product/{id}','BorrowProduct')->name('borrow.product');
        Route::post('/extend/time/{id}','ExtendTime')->name('extend.time');
    });

    // All Event Modul
    Route::controller(EventDetailController::class)->group(function (){
       Route::get('Detail/Event/{id}', 'DetailEvent')->name('DetailEvent');
       Route::post('JoinEvent', 'JoinEvent')->name('JoinEvent');
    });

});
