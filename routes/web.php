<?php

use App\Http\Controllers\AdminspaceController;
use App\Http\Controllers\AppareilsController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashbordController;
use App\Http\Controllers\DemandeursController;
use App\Http\Controllers\InterventionsController;
use App\Http\Controllers\MaterielsController;
use App\Http\Controllers\PieceRechangesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TechniciensController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
        return view('auth.login');

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashbord', [DashbordController::class, 'index'])->name('dashbord');




// creation auto route
Route::middleware(['auth'])->group(function () {

        // Profile
        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
            Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
        });

        // ADMINS
        Route::middleware(['admin'])->group(function () {
        Route::resource('techniciens', TechniciensController::class)->except(['index', 'show']);
        Route::resource('appareils', AppareilsController::class)->except(['index', 'show']);
        Route::resource('interventions', InterventionsController::class)->except(['index', 'show']);
        Route::resource('demandeurs', DemandeursController::class)->except(['index', 'show']);
        Route::resource('materiels', MaterielsController::class)->except(['index', 'show']);
        Route::resource('pieces', PieceRechangesController::class)->except(['index', 'show']);
        Route::get('/adminspace', [AdminspaceController::class, 'index'])->name('adminspace');
        Route::delete('/users/{user}', [AdminspaceController::class, 'destroy'])->name('users.destroy');

    });
    
        // User
        Route::resource('techniciens', TechniciensController::class)->only(['index', 'show']);
        Route::resource('appareils', AppareilsController::class)->only(['index', 'show']);
        Route::resource('interventions', InterventionsController::class)->only(['index', 'show']);
        Route::resource('demandeurs', DemandeursController::class)->only(['index', 'show']);
        Route::resource('materiels', MaterielsController::class)->only(['index', 'show']);
        Route::resource('pieces', PieceRechangesController::class)->only(['index', 'show']);
        

    
  
});
