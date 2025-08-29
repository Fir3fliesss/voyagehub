<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JourneyController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/signin', [AuthController::class, 'showSigninForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'signin']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard Route
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [JourneyController::class, 'index'])->name('dashboard');

    Route::get('/new-trip', function () {
        return view('user.newtrip');
    })->name('new-trip');

    Route::resource('journeys', JourneyController::class)->except(['show']);

    Route::get('/settings', [UserController::class, 'settings'])->name('settings');
    Route::post('/settings', [UserController::class, 'updateSettings'])->name('settings.update');
});

Route::resource('users', UserController::class);
