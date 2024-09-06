<?php

use App\Http\Controllers\Auth\FacebookController;
use App\Http\Controllers\Auth\GithubController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LinkedlnController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

//GOOGLE OAuth ROUTES
Route::get('/auth/google/redirect', [GoogleController::class, 'handleGoogleRedirect']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

//LINKEDLN OAuth ROUTES
Route::get('/auth/linkedln/redirect', [LinkedlnController::class, 'handleLinkedlnRedirect']);
Route::get('/auth/linkedln/callback', [LinkedlnController::class, 'handleLinkedlnCallback']);

//FACEBOOK OAuth ROUTES
Route::get('/auth/facebook/redirect', [FacebookController::class, 'handleFacebookRedirect']);
Route::get('/auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);

//GITHUB OAuth ROUTES
Route::get('/auth/github/redirect', [GithubController::class, 'handleGithubRedirect']);
Route::get('/auth/github/callback', [GithubController::class, 'handleGithubCallback']);
