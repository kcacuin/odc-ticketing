<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UploadController;
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

Route::middleware('guest')->group(function ($middleware) {
    Route::get('/send-email', [EmailController::class, 'index'])->name('send.mail');
    Route::get('/send-email', [EmailController::class, 'store'])->name('send.email.post');
});

Route::view('/', 'welcome');

require __DIR__.'/auth.php';



Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    Route::patch('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');

    Route::resource('tickets', TicketController::class);
    Route::resource('tickets.files', FileController::class);
    Route::resource('tickets.notes', NoteController::class);

    Route::post('upload', [UploadController::class, 'store']);

    Route::post('/tmp-upload', [UploadController::class, 'tmpUpload']);
    Route::get('/tmp-load/{folder}/{file_name}', [UploadController::class, 'tmpLoad'])->name('tmp-load');
    Route::delete('/tmp-delete', [UploadController::class, 'tmpDelete']);

    Route::post('/attachments', [UploadController::class, 'trixAttachmentStore'])->name('attachments.store');
});


