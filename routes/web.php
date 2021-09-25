<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::get('/ajax',[PostController::class,'index'])->name('index');

Route::get('/posts/all',[PostController::class,'allData']);
Route::post('/posts/create',[PostController::class,'addData']);

Route::get('/posts/find/{id}',[PostController::class,'editData']);

Route::post('/posts/update/{id}',[PostController::class,'updateData']);

Route::get('/post/delete/{id}',[PostController::class,'deleteData']);
