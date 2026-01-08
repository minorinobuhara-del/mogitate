<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

//Route::get('/', function () {
    //return view('welcome');
//});
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// 詳細（編集）画面
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
    ->name('products.edit');
// 更新処理
Route::put('/products/{id}', [ProductController::class, 'update'])
    ->name('products.update');
Route::get('/products/create', [ProductController::class, 'create']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::resource('products', ProductController::class);
//削除処理
Route::delete('/products/{product}', [ProductController::class, 'destroy'])
    ->name('products.destroy');
