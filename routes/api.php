<?php

use App\Http\Controllers\Autorization;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RepostController;
use App\Models\Friend;
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
Route::post('/login', [Autorization::class, 'login'])->middleware('throttle:4,1');


Route::middleware('auth:sanctum')->group(function () {
    //Все что связано с пользователем
    Route::get('/me', [Autorization::class, 'me'])->middleware('throttle:50000,1');
    Route::get('/logout', [Autorization::class, 'logout']);
    Route::post('/change/avatar', [Autorization::class, 'changeAvatar']);
    Route::post('/change/profile', [Autorization::class, 'editProfile']);
    Route::get('/user/{id}', [Autorization::class, 'findUser']);

    // Все что связано с постами
    Route::get('/post/all', [PostController::class, 'getAllPosts'])->middleware('throttle:50000,1');
    Route::post('/post/create', [PostController::class, 'createPost']);
    Route::get('/post/delete/{id}', [PostController::class, 'deletePost']);
    Route::get('/post/my', [PostController::class, 'getMyPosts'])->middleware('throttle:50000,1');
    Route::get('/post/user/{id}', [PostController::class, 'getUserPosts'])->middleware('throttle:50000,1');
    Route::post('/repost', [RepostController::class, 'add_repost']);
    Route::get('/all/repost/{id}', [RepostController::class, 'all_repost']);
    Route::delete('/delete/repost/{id}', [RepostController::class, 'delete_repost']);

    // Лайки постов
    Route::post('/likes/create', [LikeController::class, 'store']);
    Route::delete('/likes/{id}/delete', [LikeController::class, 'destroy']);
    Route::post('/likes/check', [LikeController::class, 'checkLike'])->middleware('throttle:500000,1');

    // Комментарии к постам
    Route::post('/comment/create', [CommentController::class, 'createCommnet']);
    Route::post('/comment/all', [CommentController::class, 'allPostComments']);

    // Все что связанно с друзьями
    Route::get('/maby/frineds', [FriendController::class, 'all_users'])->middleware('throttle:500000,1');
    Route::get('/my/friend', [FriendController::class, 'my_friends'])->middleware('throttle:500000,1');
    Route::delete('/delete/friend/{id}', [FriendController::class, 'delete_friend']);
    Route::get('/check/friend/{id}', [FriendController::class, 'check_status_frined'])->middleware('throttle:500000,1');
});

Route::post('/add_friend/{id}', [FriendController::class, 'add_friend']);
Route::get('/accept/friend/{id}', [FriendController::class, 'accept_frined']);
