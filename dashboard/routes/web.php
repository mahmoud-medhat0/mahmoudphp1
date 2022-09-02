<?php

use App\Http\Controllers\productcontroler;
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

//Route::get('/', function () {
//   return view('products.allproducts');
//});
Route::get('/',[productcontroler::class,'index']);
Route::get('products/all/',[productcontroler::class,'index'])->name('all');
Route::get('products/create',[productcontroler::class,'create'])->name('create');
Route::get('products/{id}/edit',[productcontroler::class,'edit'])->name('products.edit');
Route::post('products/store',[productcontroler::class,'store'])->name('products.store');
Route::delete('products/{id}/delete',[productcontroler::class,'delete'])->name('products.delete');
