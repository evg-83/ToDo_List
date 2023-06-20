<?php

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

Route::get('/', [App\Http\Controllers\TodoController::class, 'index'])->name('index');
Route::get('/fetchall', [App\Http\Controllers\TodoController::class, 'fetchall'])->name('fetchall');
Route::post('/store', [App\Http\Controllers\TodoController::class, 'store'])->name('store');
Route::post('/storeTags', [App\Http\Controllers\TodoController::class, 'storeTags'])->name('storeTags');
Route::get('/edit', [App\Http\Controllers\TodoController::class, 'edit'])->name('edit');
Route::post('/update', [App\Http\Controllers\TodoController::class, 'update'])->name('update');
Route::post('/delete', [App\Http\Controllers\TodoController::class, 'delete'])->name('delete');

Route::get('/showImage/{todo}', [App\Http\Controllers\TodoController::class, 'showImage'])->name('showImage');
Route::get('/editImage', [App\Http\Controllers\TodoController::class, 'editImage'])->name('editImage');
Route::post('/updateImage', [App\Http\Controllers\TodoController::class, 'updateImage'])->name('updateImage');
Route::post('/deleteImage', [App\Http\Controllers\TodoController::class, 'deleteImage'])->name('deleteImage');


// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
