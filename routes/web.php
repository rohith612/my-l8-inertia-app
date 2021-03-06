<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Frontend/Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('todo-item', ItemController::class)->name('*', 'todo-item');
   
    Route::resource('products-master', ProductController::class)->name('*', 'products-master');
    Route::post('products-master/{product}/remove-additional-image/{image}', 'ProductController@removeAdditionalImage')->name('products-master.product.remove-additional-image');


    Route::resource('category-master', CategoryController::class)->name('*', 'category-master');
});