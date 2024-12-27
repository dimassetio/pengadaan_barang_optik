<?php

use App\Http\Controllers\FrameController;
use App\Http\Controllers\LensaController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return redirect()->route('dashboard');
});

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
  Route::resource('users', UserController::class)->names('users');
  Route::resource('pasien', PasienController::class)->except(['show', 'create', 'edit'])->names('pasien');
  Route::resource('pesanan', PesananController::class)->except(['show', 'create', 'edit'])->names('pesanan');
  Route::resource('frame', FrameController::class)->except(['show', 'create', 'edit'])->names('frame');
  Route::resource('lensa', LensaController::class)->except(['show', 'create', 'edit'])->names('lensa');
});

// Route::middleware(['role:admin'])->group(function () {
//     Route::resource('users', UserController::class)->names('users');
// });

require __DIR__ . '/auth.php';
