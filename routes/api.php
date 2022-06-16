<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentsController;
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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);   

    Route::get('/get_all_comment', [CommentsController::class, 'get_all_comment']);
    Route::post('/add_comment', [CommentsController::class, 'add_comment']);
    Route::get('/get_single_comment/{id}', [CommentsController::class, 'get_single_comment']);
    Route::patch('/update_comment/{id}', [CommentsController::class, 'update_comment']);
    Route::delete('/delete_comment/{id}', [CommentsController::class, 'delete_comment']);
});
