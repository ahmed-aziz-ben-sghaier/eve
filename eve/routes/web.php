<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('auth/home', [App\Http\Controllers\Auth\HomeController::class, 'index'])->name('auth.home')->middleware('isAdmin');

Route::post('auth/store-category', [App\Http\Controllers\Auth\HomeController::class, 'storeCategory'])->name('category.store');

Route::post('auth/store-event', [App\Http\Controllers\Auth\HomeController::class, 'storeEvent'])->name('event.store');

Route::resource('home', App\Http\Controllers\Auth\HomeController::class);

Route::get('auth/event/{id}/edit', [App\Http\Controllers\Auth\HomeController::class, 'editEvent'])->name('event.edit');
Route::put('auth/event/{id}', [App\Http\Controllers\Auth\HomeController::class, 'updateEvent'])->name('event.update');
Route::delete('auth/event/{id}', [App\Http\Controllers\Auth\HomeController::class, 'destroyEvent'])->name('event.destroy');












Route::get('user/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('user.home');
Route::get('/user/dashboard', [App\Http\Controllers\User\HomeController::class, 'index'])->name('user.dashboard');
Route::post('/user/reserve/{event}', [App\Http\Controllers\User\HomeController::class, 'reserve'])->name('user.reserve');
Route::get('/user/reservations', [App\Http\Controllers\User\HomeController::class, 'reservations'])->name('user.reservations');
Route::post('/user/cancel-reservation/{reservation}', [App\Http\Controllers\User\HomeController::class, 'cancelReservation'])->name('user.cancelReservation');
Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('home');

Route::get('/profile/edit', [App\Http\Controllers\User\HomeController::class, 'edit'])->name('user.edit');
Route::put('/profile/update', [App\Http\Controllers\User\HomeController::class, 'update'])->name('user.update');



Route::get('/user/waiting-list', [App\Http\Controllers\User\HomeController::class, 'waitingList'])->name('user.waiting_list');
Route::post('/waiting-list/cancel/{eventId}', [App\Http\Controllers\User\HomeController::class, 'cancelWaitingList'])->name('user.cancelWaitingList');






