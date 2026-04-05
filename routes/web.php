<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EvenementielController; 
use App\Http\Controllers\EquipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () { return redirect()->route('register'); });

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard principal
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    // MODULE ÉVÉNEMENTIEL (Nettoyé pour éviter l'erreur 419 et les doublons)
   // Dans le groupe prefix('evenementiel'), modifiez la ligne update :
Route::prefix('evenementiel')->group(function () {
    Route::get('/', [EvenementielController::class, 'index'])->name('evenementiel.index');
    Route::post('/store', [EvenementielController::class, 'store'])->name('events.store');
    
    // CHANGEZ CETTE LIGNE : Enlevez le "/evenementiel" devant /update
    Route::put('/update/{id}', [EvenementielController::class, 'update'])->name('events.update');
    
    Route::delete('/{id}', [EvenementielController::class, 'destroy'])->name('events.destroy');
});

Route::prefix('evenementiel')->group(function () {
    Route::get('/', [EvenementielController::class, 'index'])->name('evenementiel.index');
    Route::post('/store', [EvenementielController::class, 'store'])->name('events.store');
    Route::put('/update/{id}', [EvenementielController::class, 'update'])->name('events.update');
    Route::delete('/{id}', [EvenementielController::class, 'destroy'])->name('events.destroy');

    // AJOUTEZ CETTE LIGNE CI-DESSOUS
    Route::post('/proforma/{id}', [EvenementielController::class, 'saveProforma'])->name('events.proforma');
    Route::get('/proforma/download/{id}', [EvenementielController::class, 'downloadProforma'])->name('events.proforma.download');
});

    // MODULE STOCK
    Route::prefix('stock')->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('equipment.index');
        Route::post('/equipments', [EquipmentController::class, 'storeEquipment'])->name('equipment.store');
    });

    // AUTRES MODULES (Définit les routes pour vos cartes Dashboard)
    Route::get('/btp', function () { return view('btp.index'); })->name('btp.index');
    Route::get('/briqueterie', function () { return view('briqueterie.index'); })->name('briqueterie.index');
    Route::get('/garderie', function () { return view('garderie.index'); })->name('garderie.index');
    Route::get('/agro', function () { return view('agro.index'); })->name('agro.index');
    Route::get('/gym', function () { return view('gym.index'); })->name('gym.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

require __DIR__.'/auth.php';