<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\TicketController;
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

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::resource('tickets', TicketController::class);
Route::middleware('auth')->resource('tickets.comments', CommentController::class);

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('tickets', [TicketController::class, 'index'])->name('tickets');
//     Route::post('tickets', [TicketController::class, 'store']);
//     Route::get('tickets/add', [TicketController::class, 'create']);
// });
