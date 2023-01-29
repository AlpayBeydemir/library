<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\ProductController;
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

// All Dashboard Routes
Route::controller(DashboardController::class)->group(function (){
   Route::get('/dashboard','index')->name('dashboard');


});

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

