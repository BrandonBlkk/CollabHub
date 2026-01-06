<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\FindFreelancersController;
use App\Http\Controllers\Admin\FreelancerController;
use App\Http\Controllers\Client\JobController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\SettingController;
use App\Http\Controllers\Freelancer\ProfileController as FreelancerProfileController;
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

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::put('/settings/reset', [SettingController::class, 'reset'])->name('settings.reset');

    // Admin-Only Routes
    Route::middleware(['auth', 'verified', 'role:admin|super_admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');
            Route::get('/manage-clients', [ClientController::class, 'index'])
                ->name('manage-clients');
            Route::get('/manage-freelancers', [FreelancerController::class, 'index'])
                ->name('manage-freelancers');
        });

    // Client-Only Routes
    Route::middleware('role:client')->group(function () {
        Route::get('/find-freelancers', [FindFreelancersController::class, 'index'])
            ->name('find-freelancers');
        Route::get('/freelancer/{id}', [FindFreelancersController::class, 'freelancerProfile'])
            ->name('freelancer-profile');
        Route::resource('my-jobs', JobController::class);

        // Profile
        Route::resource('profile', ProfileController::class);
    });

    //  Freelancer-Only Routes
    Route::middleware('role:freelancer')->group(function () {
        Route::resource('freelancer-profile', FreelancerProfileController::class);

        // Experience
        Route::post('freelancer-profile/experience', [FreelancerProfileController::class, 'storeExperience'])
            ->name('freelancer-profile.experience.store');
        Route::get('freelancer-profile/experience/{id}/edit', [FreelancerProfileController::class, 'editExperience'])
            ->name('freelancer-profile.experience.edit');
        Route::put('freelancer-profile/experience/{id}', [FreelancerProfileController::class, 'updateExperience'])
            ->name('freelancer-profile.experience.update');
        Route::delete('freelancer-profile/experience/{id}', [FreelancerProfileController::class, 'deleteExperience'])
            ->name('freelancer-profile.experience.delete');

        // Certificate
        Route::post('freelancer-profile/certificate', [FreelancerProfileController::class, 'storeCertificate'])
            ->name('freelancer-profile.certificate.store');
        Route::get('freelancer-profile/certificate/{id}/edit', [FreelancerProfileController::class, 'editCertificate'])
            ->name('freelancer-profile.certificate.edit');
        Route::put('freelancer-profile/certificate/{id}', [FreelancerProfileController::class, 'updateCertificate'])
            ->name('freelancer-profile.certificate.update');
        Route::delete('freelancer-profile/certificate/{id}', [FreelancerProfileController::class, 'deleteCertificate'])
            ->name('freelancer-profile.certificate.delete');
    });
});

require __DIR__ . '/auth.php';
