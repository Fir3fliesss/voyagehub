<?php

use App\Http\Controllers\AdminController;
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

    Route::get('/new-trip', [JourneyController::class, 'create'])->name('new-trip');

    Route::resource('journeys', JourneyController::class)->except(['show']);

    // Travel Request Management for Users
    Route::resource('travel-requests', App\Http\Controllers\TravelRequestController::class);

    // Notifications
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [App\Http\Controllers\NotificationController::class, 'getUnreadCount']);
    Route::get('/notifications/recent', [App\Http\Controllers\NotificationController::class, 'getRecent']);

    // User Profile Management
    Route::resource('users', UserController::class);
});

// routes/web.php
Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function () {
<<<<<<< HEAD
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User Management Routes
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // Trip Management Routes
    Route::get('/trips', [AdminController::class, 'trips'])->name('admin.trips.index');

    // Trip Management

=======
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/chart-data', [App\Http\Controllers\Admin\AdminController::class, 'getChartData'])->name('admin.chart-data');

    // User Management
    Route::resource('/users', App\Http\Controllers\Admin\UserController::class, [
        'names' => [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]
    ]);

    // Trip Management (Admin)
    Route::resource('/journeys', App\Http\Controllers\Admin\JourneyController::class, [
        'names' => [
            'index' => 'admin.journeys.index',
            'create' => 'admin.journeys.create',
            'store' => 'admin.journeys.store',
            'show' => 'admin.journeys.show',
            'edit' => 'admin.journeys.edit',
            'update' => 'admin.journeys.update',
            'destroy' => 'admin.journeys.destroy',
        ]
    ]);
>>>>>>> 4b0d94f (feat: implement travel request management system)

    // App Configuration Management
    Route::resource('/app-configurations', App\Http\Controllers\Admin\AppConfigurationController::class, [
        'names' => [
            'index' => 'admin.app-configurations.index',
            'create' => 'admin.app-configurations.create',
            'store' => 'admin.app-configurations.store',
            'edit' => 'admin.app-configurations.edit',
            'update' => 'admin.app-configurations.update',
            'destroy' => 'admin.app-configurations.destroy',
        ]
    ]);
    Route::post('/app-configurations/bulk-update', [App\Http\Controllers\Admin\AppConfigurationController::class, 'bulkUpdate'])
        ->name('admin.app-configurations.bulk-update');

    // Travel Request Management for Admin
    Route::resource('/travel-requests', App\Http\Controllers\Admin\TravelRequestController::class, [
        'names' => [
            'index' => 'admin.travel-requests.index',
            'show' => 'admin.travel-requests.show',
        ]
    ])->only(['index', 'show']);
    Route::post('/travel-requests/{travelRequest}/approve', [App\Http\Controllers\Admin\TravelRequestController::class, 'approve'])
        ->name('admin.travel-requests.approve');
    Route::post('/travel-requests/{travelRequest}/reject', [App\Http\Controllers\Admin\TravelRequestController::class, 'reject'])
        ->name('admin.travel-requests.reject');
    Route::post('/travel-requests/bulk-action', [App\Http\Controllers\Admin\TravelRequestController::class, 'bulkAction'])
        ->name('admin.travel-requests.bulk-action');

    // Report Management
    Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])
        ->name('admin.reports.index');
    Route::post('/reports/export-journeys', [App\Http\Controllers\Admin\ReportController::class, 'exportJourneys'])
        ->name('admin.reports.export-journeys');
    Route::post('/reports/export-requests', [App\Http\Controllers\Admin\ReportController::class, 'exportTravelRequests'])
        ->name('admin.reports.export-requests');
    Route::post('/reports/generate', [App\Http\Controllers\Admin\ReportController::class, 'generateReport'])
        ->name('admin.reports.generate');
    Route::post('/reports/template', [App\Http\Controllers\Admin\ReportController::class, 'generateFromTemplate'])
        ->name('admin.reports.template');
});
