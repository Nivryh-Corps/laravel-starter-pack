<?php

use App\Http\Controllers\AdminController;
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

Route::get('/admin', [AdminController::class, 'homepage']);
Route::get('/admin/products', [AdminController::class, 'productspage']);
Route::any('/admin/products/add', [AdminController::class, 'addproduct']);
Route::any('/admin/products/{id}', [AdminController::class, 'productdetail']);
Route::get('/admin/categories', [AdminController::class, 'categoriespage']);
Route::get('/admin/orders', [AdminController::class, 'cartspage']);
Route::get('/admin/orders/detail/{id}', [AdminController::class, 'cartdetailpage']);
Route::post('/admin/categories', [AdminController::class, 'categoriespage']);
Route::get('/admin/users', [AdminController::class, 'userspage']);
Route::get('/admin/users/{id}', [AdminController::class, 'userdetailpage']);

Route::get('/admin/carts', [AdminController::class, 'cartspage']);
Route::get('/admin/users', [AdminController::class, 'userspage']);
