<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
Route::resource('tickets', TicketController::class);
Route::middleware('auth')->resource('tickets.comments', CommentController::class);


Route::post('/attachments', function () {
    request()->validate([
        'attachment' => ['required', 'file'],
    ]);

    $path = request()->file('attachment')->store('ticket-attachments', 'public');

    return [
        'image_url' => Storage::disk('public')->url($path),
    ];
})->middleware(['auth'])->name('attachments.store');

Route::delete('/tickets/delete-file/{fileName}',
[TicketController::class, 'deleteFile'])->name('tickets.deleteFile');
