<?php


use AppUser\User\Http\Controllers\UserController;
use AppUser\User\Http\middleware\AuthMiddleware;

Route::prefix('api/auth')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
});

Route::prefix('api/users')
    ->middleware(AuthMiddleware::class)
    ->group(function () {
        Route::get('/', [UserController::class, 'index']);
    });
