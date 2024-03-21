<?php

use App\Http\Controllers\FileController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Livewire\UserList;
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

require __DIR__.'/auth.php';

Route::get('admin', UserList::class)->name('admin.index')->middleware('admin');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->name('profile');
    
    // Route::get('admin', [UserController::class, 'index'])->name('admin.index');

    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/incident/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/incident-{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    Route::get('/tickets/incident-{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
    Route::patch('/tickets/incident-{ticket}', [TicketController::class, 'update'])->name('tickets.update');
    Route::delete('/tickets/incident-{ticket}', [TicketController::class, 'destroy'])->name('tickets.destroy');

    // Route::resource('tickets', TicketController::class);
    Route::resource('tickets.files', FileController::class);
    Route::resource('tickets.notes', NoteController::class);

    Route::post('upload', [UploadController::class, 'store']);

    Route::post('/tmp-upload', [UploadController::class, 'tmpUpload']);
    Route::get('/tmp-load/{folder}/{file_name}', [UploadController::class, 'tmpLoad'])->name('tmp-load');
    Route::delete('/tmp-delete', [UploadController::class, 'tmpDelete']);

    Route::post('/attachments', [UploadController::class, 'trixAttachmentStore'])->name('attachments.store');
});


