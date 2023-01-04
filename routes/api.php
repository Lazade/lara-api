<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function(){
    Route::get('hello', function() {
        return "Hello world";
    });
    // auth
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    //
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{id}', [ProductController::class, 'show']);
    // Route::group(['middleware' => 'auth:sanctum'], function() {
    //     // auth
    //     Route::get('logout', [AuthController::class, 'logout']);
    //     // products
    //     Route::post('products', [ProductController::class, 'store']);
    //     Route::put('products/{id}', [ProductController::class, 'update']);
    //     Route::delete('products/{id}', [ProductController::class, 'delete']);
    // });
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function() {
    // auth
    Route::get('logout', [AuthController::class, 'logout']);
    // products
    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'delete']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::group()
