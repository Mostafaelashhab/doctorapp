<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(ContactController::class)->group(function () {
    Route::get('/contacts', 'index');
});
Route::controller(SocialController::class)->group(function () {
    Route::get('/socials', 'index');
});
Route::controller(CategoryController::class)->group(function () {
    Route::get('/categories', 'index');
});
Route::controller(CustomerController::class)->prefix('v1')->group(function () {
    Route::post('/register', 'register');
    Route::get('/user', 'getProfile');
    Route::post('/user/logout', 'logout');
    Route::post('/user/delete', 'deleteAccount');
    Route::put('/user/update', 'updateProfile');
    Route::post('/login', 'login');
});