<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Contact form route
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/contact', [AdminController::class, 'contactUser'])->name('users.contact');
    Route::post('/users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
    
    // Planning routes
    Route::get('/planning', [AdminController::class, 'planning'])->name('planning');
    Route::post('/events', [AdminController::class, 'storeEvent'])->name('events.store');
    Route::put('/events/{event}', [AdminController::class, 'updateEvent'])->name('events.update');
    Route::delete('/events/{event}', [AdminController::class, 'deleteEvent'])->name('events.delete');
    
    Route::get('/invitation-codes', [AdminController::class, 'invitationCodes'])->name('invitation-codes');
    Route::post('/invitation-codes', [AdminController::class, 'generateInvitationCode'])->name('invitation-codes.generate');
    Route::delete('/invitation-codes/{code}', [AdminController::class, 'revokeInvitationCode'])->name('invitation-codes.revoke');
    
    // Contact messages management
    Route::get('/contact-messages', [ContactController::class, 'indexAdmin'])->name('contact-messages');
    Route::patch('/contact-messages/{message}/read', [ContactController::class, 'markAsRead'])->name('contact-messages.read');
    Route::patch('/contact-messages/{message}/unread', [ContactController::class, 'markAsUnread'])->name('contact-messages.unread');
    Route::patch('/contact-messages/{message}/archive', [ContactController::class, 'archive'])->name('contact-messages.archive');
    Route::patch('/contact-messages/{message}/unarchive', [ContactController::class, 'unarchive'])->name('contact-messages.unarchive');
    Route::get('/contact-messages/unread-count', [ContactController::class, 'unreadCount'])->name('contact-messages.unread-count');
});

// Employee routes
Route::middleware(['auth'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [EmployeeController::class, 'profile'])->name('profile');
    Route::get('/planning', [EmployeeController::class, 'planning'])->name('planning');
    Route::get('/tasks', [EmployeeController::class, 'tasks'])->name('tasks');
});

// Legacy dashboard route (redirect based on role)
Route::get('/dashboard', function () {
    if (auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('employee.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::patch('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
});

require __DIR__.'/auth.php';
