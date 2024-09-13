<?php

use App\Http\Controllers\MahasiswaController;
use Illuminate\Support\Facades\Route;

// Route::statamic('example', 'example-view', [
//    'title' => 'Example'
// ]);

Route::get('/', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::delete('/delete/{id}', [MahasiswaController::class, 'destroy'])->name('mahasiswa.destroy');
Route::post('/store-mahasiswa', [MahasiswaController::class, 'store'])->name('mahasiswa.store');