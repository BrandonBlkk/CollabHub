<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\FindFreelancersController;
use App\Http\Controllers\Admin\FreelancerController;
use App\Http\Controllers\Client\JobController;
use App\Http\Controllers\Client\ProfileController;
use App\Http\Controllers\Client\SettingController;
use App\Http\Controllers\EarningsController;
use App\Http\Controllers\Freelancer\CertificateController;
use App\Http\Controllers\Freelancer\EducationController;
use App\Http\Controllers\Freelancer\ExperienceController;
use App\Http\Controllers\Freelancer\FindJobsContoller;
use App\Http\Controllers\Freelancer\LanguageController;
use App\Http\Controllers\Freelancer\ProfileController as FreelancerProfileController;
use App\Http\Controllers\Freelancer\SkillController;
use App\Http\Controllers\MessagesController;
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

    // Messages
    Route::get('/messages', [MessagesController::class, 'index'])->name('messages.index');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::put('/settings/reset', [SettingController::class, 'reset'])->name('settings.reset');

    // User Languages Routes
    Route::apiResource('freelancer-profile/languages', LanguageController::class)
        ->except('show');

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

        // Find Jobs
        Route::get('/find-jobs', [FindJobsContoller::class, 'index'])->name('find-jobs');
        Route::get('/find-jobs/jobs', [FindJobsContoller::class, 'getJobs'])->name('find-jobs.jobs');
        Route::get('/find-jobs/jobs/{id}', [FindJobsContoller::class, 'getJob'])->name('jobs.show');

        // Skill
        Route::get('/skills/search', [SkillController::class, 'searchSkill'])->name('skills.search');
        Route::get('/skills/{skill}/related', [SkillController::class, 'relatedSkills'])->name('skills.related');
        Route::post('/skills/store', [SkillController::class, 'storeSkills'])->name('skills.store');
        Route::delete('/skills/{skill}', [SkillController::class, 'removeSkill'])->name('skills.remove');

        // Experience
        Route::apiResource('freelancer-profile/experiences', ExperienceController::class)
            ->except('index');

        // Education
        Route::apiResource('freelancer-profile/educations', EducationController::class)
            ->except('index');

        // Certificate
        Route::apiResource('freelancer-profile/certificates', CertificateController::class)
            ->except('index');

        // Backup and Restore
        Route::get('settings/trash-data', [SettingController::class, 'getTrashData'])
            ->name('settings.trash.data');
        Route::post('/settings/restore/{type}/{id}', [SettingController::class, 'restoreItem'])->name('settings.restore');
        Route::delete('/settings/delete-permanently/{type}/{id}', [SettingController::class, 'permanentlyDelete'])->name('settings.delete.permanent');
        Route::post('/settings/trash/empty', [SettingController::class, 'emptyTrash'])->name('settings.trash.empty');

        // Earnings
        Route::get('/earnings', [EarningsController::class, 'earnings'])->name('earnings');
    });
});

require __DIR__ . '/auth.php';
