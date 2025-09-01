<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostApiController;
use App\Http\Controllers\Api\TokenApiController;

Route::get('/get-token', [TokenApiController::class, 'generateToken']);

Route::middleware('api.token')
->prefix('posts')
->group(function () {
    Route::get('/', [PostApiController::class, 'all']);
    Route::get('/selected/{id}', [PostApiController::class, 'SelectedPost']);
    Route::get('/category/{categoryId}', [PostApiController::class, 'Category']);
    Route::get('/category/{categoryId}/selected/{postId}', [PostApiController::class, 'CategorySelectedId']);
});