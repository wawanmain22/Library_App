<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksReaderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [BooksReaderController::class, 'dashboard'])->name('dashboard');
    Route::resource('readers', BooksReaderController::class);
    Route::get('/export-excel', [BooksReaderController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export-pdf', [BooksReaderController::class, 'exportPDF'])->name('export.pdf');
    Route::post('/import', [BooksReaderController::class, 'import'])->name('import');
    Route::get('/template-import', [BooksReaderController::class, 'downloadTemplate'])->name('template.import');
    Route::get('/template-import/{type}', [BooksReaderController::class, 'downloadTemplate'])
        ->where('type', 'xlsx|csv')
        ->name('template.import');

});
