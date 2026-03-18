<?php


use AppUser\User\Http\Controllers\UserController;

Route::prefix('api/auth')->group(function () {

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
});
