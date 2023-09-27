<?php

use App\Http\Controllers\AdminController;
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
    return view('user.index');
});
Route::get('/login' ,function(){
    return view('admin.login');
})->name('login');
Route::post('/post/login', [AdminController::class, 'loginUser'])->name('loginUser');

Route::get('/register', function(){
    return view('admin.register');
});
Route::post('/post/register', [AdminController::class,'registerUser'])->name('registerUser');
Route::get('/logout',[AdminController::class,'logout'])->name('logout');

Route::get('/enggochicken', [AdminController::class,'index'])->middleware('auth')->name('index_admin');
Route::get('/enggochicken/{data}', [AdminController::class,'pic_area_index'])->middleware('auth')->name('pic_area_index');
Route::post('/post/table', [AdminController::class, 'create_table'])->middleware('auth')->name('create_table');
Route::post('/post/menu', [AdminController::class,'create_menu'])->middleware('auth')->name('create_menu');

Route::get('/other', [AdminController::class,'view_other'])->middleware('auth')->name('view_other');
Route::post('/post/area', [AdminController::class, 'create_area_other'])->middleware('auth')->name('create_area_other');

Route::get('/order/{id}', [AdminController::class,'order'])->middleware('auth')->name('order');
Route::post('/post/order/{id}', [AdminController::class, 'create_order'])->middleware('auth')->name('create_order');
Route::post('/checkout/order', [AdminController::class, 'checkout'])->middleware('auth')->name('checkout');
Route::get('/destroy/order/bill', [AdminController::class, 'destroy_BillOrder'])->middleware('auth')->name('destroy_BillOrder');