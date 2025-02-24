<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

//Halaman Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

//Halaman Products Route using Prefixes for Groups Route that consist a lot of route
Route::prefix('/category')->group(function(){
    Route::get('/FoodBeverages', [ProductsController::class, 'FoodBeverages']);
    Route::get('/BeautyHealth', [ProductsController::class, 'BeautyHealth']);
    Route::get('/HomeCare', [ProductsController::class, 'HomeCare']);
    Route::get('/BabyKid', [ProductsController::class, 'BabyKid']);
});

//Halaman User Route using Param where the method/function that take is from the [UserController::class, 'show']
Route::get('/user/{id}/name/{name}', [UserController::class, 'show']);

//Halaman Sales Route using Param where the method/function that take is from the [SalesController::class, 'index']
Route::get('/sales', [SalesController::class, 'index']);
