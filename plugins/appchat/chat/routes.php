<?php

use AppChat\Chat\Http\Controllers\ConversationController;
use AppChat\Chat\Http\Controllers\ConversationUserController;
use AppChat\Chat\Http\Controllers\MessageController;
use AppUser\User\Http\middleware\AuthMiddleware;

Route::prefix('api')->middleware(AuthMiddleware::class)->group(function () {
    Route::prefix('conversations')->group(function () {
        Route::get('/', [ConversationController::class, 'index']);
        Route::get('/{conversation}', [ConversationController::class, 'show']);
        Route::post('/store', [ConversationController::class, 'store']);
        Route::post('/{conversation}/update', [ConversationController::class, 'update']);
        Route::delete('/{conversation}/destroy', [ConversationController::class, 'destroy']);
        //conversation user
        Route::post('{conversation}/attach-users', [ConversationUserController::class, 'attach']);
        Route::post('{conversation}/detach-users', [ConversationUserController::class, 'detach']);
    });
    Route::prefix('conversations/{conversation}/messages')->group(function () {
        Route::get('/', [MessageController::class, 'index']);
        Route::post('/store', [MessageController::class, 'store']);
        Route::delete('{id}/destroy', [MessageController::class, 'destroy']);
    });
});
