<?php

use App\Http\Controllers\LinkedinController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('auth/linkedin',[LinkedinController::class,'redirectToLinkedin'])->name('linkedin.homePage');
Route::get('auth/linkedin/callback',[LinkedinController::class,'handleLinkedinCallback'])->name('linkedin.redirect');
