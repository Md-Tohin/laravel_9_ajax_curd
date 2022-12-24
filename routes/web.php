<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/room/get-rooms', [RoomController::class, 'getRooms']);
Route::post('/room/store', [RoomController::class,'storeRoom']);
Route::post('/room/update', [RoomController::class,'updateRoom']);
Route::get('/room/delete/{id}', [RoomController::class,'deleteRoom']);
Route::resource('room', RoomController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
