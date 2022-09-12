<?php

use App\Http\Controllers\api\PostsController;
use App\Http\Controllers\api\UsersController;
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

Route::get('/users', [UsersController::class, 'index']);

Route::controller(PostsController::class)->group(function () {

    Route::get('/posts/top', 'top');

    Route::get('/posts/{id}', 'show');
});
