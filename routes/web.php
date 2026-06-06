<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Brevo\BrevoController;
use App\Http\Controllers\Mailler\MailController;
use App\Http\Controllers\Mailler\TemplateController;
use App\Http\Controllers\MailSettingController;

/*
|--------------------------------------------------------------------------
| Guest Routes (Giriş etməyənlər üçün)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    // Fayl adındakı "welcome" kiçik hərflə və düzgün yazılmalıdır
    return view('frontend.welcome');
});

Route::middleware('guest')->group(function () {

    Route::get('/softpanel/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/softpanel/login', [AuthController::class, 'login'])->name('admin.login.post');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Giriş edənlər üçün)
|--------------------------------------------------------------------------
*/


Route::prefix('admin')
    ->as('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

        // Ana Səhifə
        Route::get('/', [PageController::class, 'index'])->name('home');
        Route::get('/profile', [AuthController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        // Mailer (E-poçt idarəetməsi)
        Route::prefix('mailer')->as('mailer.')->group(function () {
            Route::get('/', [MailController::class, 'form'])->name('form');
            Route::post('/send', [MailController::class, 'send'])->name('send');
            Route::get('/report', [MailController::class, 'report'])->name('report');
            Route::post('/sync', [MailController::class, 'syncEvents'])->name('sync');
            Route::post('/webhook/brevo', [MailController::class, 'webhook'])->name('webhook');
        });

        // Contacts (İstifadəçi idarəetməsi)
        Route::prefix('contacts')->as('contacts.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/upload', [UserController::class, 'uploadForm'])->name('upload.form');
            Route::post('/upload', [UserController::class, 'upload'])->name('upload');
            Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
            Route::post('/delete-selected', [UserController::class, 'deleteSelected'])->name('delete.selected');
            Route::post('/delete-all', [UserController::class, 'deleteAll'])->name('deleteAll');
        });
        Route::prefix('templates')->as('templates.')->group(function () {
            Route::get('/', [TemplateController::class, 'index'])->name('index'); // Siyahı
            Route::get('/create', [TemplateController::class, 'create'])->name('create'); // Yaratma səhifəsi
            Route::post('/store', [TemplateController::class, 'store'])->name('store'); // Bazaya yazmaq
            Route::delete('/{id}', [TemplateController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/edit', [TemplateController::class, 'edit'])->name('edit');
            Route::put('/{id}', [TemplateController::class, 'update'])->name('update');
            Route::post('templates/{id}/duplicate', [TemplateController::class, 'duplicate'])
                ->name('duplicate');
        });
        Route::prefix('settings')->as('settings.')->group(function () {
            Route::get('/mail', [MailSettingController::class, 'index'])->name('mail');
            Route::post('/mail', [MailSettingController::class, 'update'])->name('mail.update');
        });
        // // Cards (Bank Kartları)
        // Route::prefix('cards')->as('cards.')->group(function () {
        //     Route::get('/', [CardController::class, 'index'])->name('index');
        //     Route::get('/create', [CardController::class, 'create'])->name('create');
        //     Route::post('/store', [CardController::class, 'store'])->name('store');
        //     Route::get('/{id}/edit', [CardController::class, 'edit'])->name('edit');
        //     Route::put('/{id}/update', [CardController::class, 'update'])->name('update');
        //     Route::delete('/{id}/delete', [CardController::class, 'destroy'])->name('destroy');
        //     Route::get('/show-card', [CardController::class, 'showSingle'])->name('show_single');
        //     Route::post('/{id}/activate', [CardController::class, 'activate'])->name('activate');
        // });

        // Brevo Statistics
        Route::get('/brevo/statistics', [BrevoController::class, 'showEmailStatistics'])->name('brevo.statistics');
    });
