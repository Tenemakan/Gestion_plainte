<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlainteController;

Route::get('/', function () {
    return view('welcome');
});

// Routes d'authentification
Route::get('/login', [UserController::class, 'showLoginForm'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.post');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Routes pour les utilisateurs
Route::middleware('auth')->group(function () {
    Route::get('/users', [PlainteController::class, 'mesPlaintes'])->name('users');
    Route::get('/user/profile/{id}', [UserController::class, 'show'])->name('user.show');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    
    // Routes pour le profil de l'utilisateur connecté
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
});

// Routes pour les plaintes (côté utilisateur)
Route::middleware('auth')->group(function () {
    Route::get('/plainte/create', [PlainteController::class, 'create'])->name('plainte.create');
    Route::post('/plainte/store', [PlainteController::class, 'store'])->name('plainte.store');
    Route::get('/plainte/show/{id}', [PlainteController::class, 'show'])->name('plainte.show');
    Route::delete('/plainte/destroy/{id}', [PlainteController::class, 'destroy'])->name('plainte.destroy');
    Route::get('/plainte_en_cours', [PlainteController::class, 'mesPlaintesEnCours'])->name('plainte_en_cours');
    Route::get('/plainte_terminee', [PlainteController::class, 'mesPlaintesTerminees'])->name('plainte_terminee');
    Route::get('/plainte_refusee', [PlainteController::class, 'mesPlaintesRefusees'])->name('plainte_refusee');
});
Route::post('/plainte/marquer-comme-lu/{id}', [PlainteController::class, 'marquerCommeLu'])->name('plainte.marquer_comme_lu');

// Routes pour l'administration
Route::middleware('auth')->group(function () {
    Route::get('/admin', [UserController::class, 'admin'])->name('admin');
});

// Routes pour les plaintes (côté admin)
Route::middleware('auth')->group(function () {
    Route::get('/admin_plainte_en_cours', [PlainteController::class, 'enCours'])->name('admin_plainte_en_cours');
    Route::get('/admin_plainte_terminee', [PlainteController::class, 'terminees'])->name('admin_plainte_terminee');
    Route::get('/admin_plainte_refusee', [PlainteController::class, 'refusees'])->name('admin_plainte_refusee');
    Route::get('/admin/plainte/repondre/{id}', [PlainteController::class, 'repondre'])->name('admin.plainte.repondre');
    Route::put('/admin/plainte/update-reponse/{id}', [PlainteController::class, 'updateReponse'])->name('admin.plainte.update_reponse');
    Route::delete('/admin/plainte/delete/{id}', [PlainteController::class, 'destroy'])->name('admin.plainte.delete');
});

// Routes pour les utilisateurs (côté admin)
Route::middleware('auth')->group(function () {
    Route::get('/admin_utilisateur', [UserController::class, 'index'])->name('admin_utilisateur');
    Route::delete('/admin/user/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.delete');
});
    