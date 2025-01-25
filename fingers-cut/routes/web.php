<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\UserController;
use Database\Factories\RoleTache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Route du dashboard (avec affichage dynamique du menu en fonction des tâches de l'utilisateur)
Route::get('/dashboard', function () {
    $user = Auth::user();

    // Récupérer les tâches que l'utilisateur a le droit de voir
    $taches = RoleTache::where('user_id', $user->id)
        ->where('can_view', true)
        ->with('tache')
        ->get();

    return view('dashboard', compact('taches'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes protégées (profil)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route pour accéder à la page planning (protégée par un middleware qui vérifie les permissions)
Route::get('/planning', function () {
    return view('taches.planning');
})->middleware('role.tache:1,can_view')->name('planning');

// Authentification Breeze
require __DIR__.'/auth.php';

Route::resource('taches', TacheController::class)->middleware('auth');

Route::resource('users', UserController::class)->middleware('auth');
