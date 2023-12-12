<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\MagazineController;
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

Route::prefix('/auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/get-me', [AuthController::class, 'getMe']);
    Route::delete('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:api')->group(function () {
    Route::prefix('/magazine')->group(function () {
        Route::get('/', [MagazineController::class, 'get']);
        Route::get('/{id}', [MagazineController::class, 'getOne']);
        Route::post('/', [MagazineController::class, 'store']);
        Route::put('/{id}', [MagazineController::class, 'update']);
        Route::delete('/{id}', [MagazineController::class, 'destroy']);
        //TODO: Route::post('/{id}/thumbnail', [MagazineController::class, 'updateThumbnail']);

        Route::post('/{id}/category', [MagazineController::class, 'addCategory']);
        Route::delete('/{id}/category', [MagazineController::class, 'removeCategory']);
    });

    Route::prefix('/division')->group(function () {
        Route::get('/', [DivisionController::class, 'get']);
        Route::get('/{id}', [DivisionController::class, 'getOne']);
        Route::post('/', [DivisionController::class, 'store']);
        Route::put('/{id}', [DivisionController::class, 'update']);
        Route::delete('/{id}', [DivisionController::class, 'destroy']);
    });

    Route::prefix('/category')->middleware('role:admin')->group(function () {
        Route::get('/', [CategoryController::class, 'get']);
        Route::get('/{id}', [CategoryController::class, 'getOne']);
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
});
