<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Products
Route::resource('products', ProductController::class);
Route::prefix('product')->group(function () {
    Route::post('/import', [ProductController::class, 'importXml']);
    Route::get('/main-data', [ProductController::class, 'getMainData']);
});
