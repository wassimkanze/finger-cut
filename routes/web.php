<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PlanningSlotController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EmployeeProjectController;
use App\Http\Controllers\ContactController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', function() {
        auth()->logout();
        return redirect('/');
    })->name('logout');

    Route::middleware([RoleMiddleware::class.':admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
            Route::resource('projects', ProjectController::class);
            Route::resource('planning', PlanningSlotController::class);
            Route::resource('jobs', JobController::class);
            Route::resource('messages', MessageController::class);
            Route::resource('users', UserController::class);
        });
    });

    Route::middleware([RoleMiddleware::class.':employee'])->group(function () {
        Route::get('/employee/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
        Route::get('/employee/projects', [EmployeeController::class, 'projects'])->name('employee.projects');
        Route::get('/employee/projects/{id}', [EmployeeProjectController::class, 'show'])->name('employee.projects.show');
        Route::get('/employee/users', [EmployeeController::class, 'users'])->name('employee.users')->middleware('auth', 'role:employee');
    });
});

Route::get('/login', function() {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', function() {
    return view('auth.forgot-password');
})->name('password.request');

Route::view('/legals', 'legal')->name('legal');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

require __DIR__.'/auth.php';