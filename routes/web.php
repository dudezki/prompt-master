<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// create a new route for database migration
Route::get('/migrate', function () {
    Artisan::call('migrate');
    return 'Migration complete';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('prompt', \App\Http\Controllers\PromptController::class);
Route::resource('card', \App\Http\Controllers\PromptCardController::class);

Route::prefix('api')->group(function() {
    Route::resource('tools', \App\Http\Controllers\PromptToolsController::class);
});
