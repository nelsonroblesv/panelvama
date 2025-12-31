<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Panel\MarcaTable;
use App\Livewire\Panel\UserTable;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/profile', function () {
    return view('panel.users');
})->middleware(['auth', 'verified'])->name('profile.edit');

Route::middleware('auth')->group(function () {
    Route::get('/marcas', MarcaTable::class)->name('marcas');
    Route::get('/users', UserTable::class)->name('users');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
