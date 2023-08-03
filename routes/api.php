<?php

use App\Http\Controllers\Autorization;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [Autorization::class, 'register']);
Route::post('/login', [Autorization::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    //Все что связано с пользователем
    Route::get('/me', [Autorization::class, 'me']);
    Route::get('/logout', [Autorization::class, 'logout']);
    Route::post('/change/avatar', [Autorization::class, 'changeAvatar']);
    Route::post('/change/profile', [Autorization::class, 'editProfile']);

    // Все что связано с постами
    Route::get('/post/all', [PostController::class, 'getAllPosts']);
    Route::post('/post/create', [PostController::class, 'createPost']);

    // Лайки постов
    Route::post('/likes/create', [LikeController::class, 'store']);
    Route::delete('/likes/{id}/delete', [LikeController::class, 'destroy']);
});
