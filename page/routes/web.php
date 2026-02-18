<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\NotificationController;

Route::get('/', [AuthController::class, 'showLanding'])->name('landing');
Route::get('/best-person', [AuthController::class, 'showBestPerson'])->name('best-person');
Route::post('/verify-name', [AuthController::class, 'verifyName'])->name('verify.name');
Route::post('/verify-email', [AuthController::class, 'verifyEmail'])->name('verify.email');
Route::post('/verify-best-person', [AuthController::class, 'verifyBestPerson'])->name('verify.best-person');

Route::middleware(['auth.custom'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/presentation', [PresentationController::class, 'index'])->name('presentation');
    Route::get('/presentation/folder/{slug}', [PresentationController::class, 'showFolder'])->name('presentation.folder');
    Route::get('/media/{id}/signed', [PresentationController::class, 'signedMedia'])->name('media.signed');
    Route::get('/gallery', [PresentationController::class, 'gallery'])->name('gallery');
    
    Route::post('/send-notification', [NotificationController::class, 'send'])->name('notification.send');
});
