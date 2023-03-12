<?php

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BorrowProductController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\Frontend\UserController;
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
//   Route::get('/delete/product/{id}','DeleteProduct')->name('delete.product');

    });


    // All Borrow Product
    Route::controller(BorrowProductController::class)->group(function (){
       Route::post('/borrow/product/{id}','BorrowProduct')->name('borrow.product');
    });
});


Route::group(['middleware' => 'user_check:user'], function (){

    // Auth Routes
    Route::get('/library', [CustomAuthController::class, 'Library'])->name('library');

    // User Routes
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::post('add_address', [UserController::class, 'AddAddress'])->name('add_address');
    Route::get('/delete/address/{id}',[UserController::class, 'DeleteAddress'])->name('delete.address');

    // Product Detail
    Route::controller(ProductDetailController::class)->group(function (){
        Route::get('/product/detail/{id}', 'ShowProduct')->name('product-detail');
    });

});
