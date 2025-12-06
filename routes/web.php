<?php

use App\Http\Controllers\FindFreelancersController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Force the user to login
Route::redirect('/login', '/')->name('login');

// Public Routes
Route::get('/', function () {
    return view('startup');
})->name('startup');

// Protected Routes
Route::middleware(['auth', 'verified'])->group(function () {

    // User-Only Routes
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin-Only Routes
    Route::middleware(['auth', 'verified', 'role:admin|super_admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');
    });

    // Client-Only Routes
    Route::middleware('user.type:client')->group(function () {
        Route::get('/find-freelancers', [FindFreelancersController::class, 'index'])
            ->name('find-freelancers');
        Route::get('/freelancer/{id}', [FindFreelancersController::class, 'freelancerProfile'])
            ->name('freelancer-profile');
    });

    //  Freelancer-Only Routes
    Route::middleware('user.type:freelancer')->group(function () {});
});

require __DIR__ . '/auth.php';
