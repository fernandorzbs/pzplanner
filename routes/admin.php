<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CampanaController;
use App\Http\Controllers\admin\ContactoController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/',         [RegisterController::class, 'login'])->name('admin.login');
Route::post('/',        [RegisterController::class, 'loginPost'])->name('admin.login.post');
Route::get('/logout',   [RegisterController::class, 'logout'])->name('admin.logout');

Route::middleware(['role:administrador|vendedor'])->group(function () {
    //DASHBOARD
    Route::get('/dashboard',            [DashboardController::class, 'dashboard'])->name('dashboard');
    //ADMINISTRADORES
    Route::resource('administradores',  AdminController::class)->names('admin');
    //CONTACTOS
    Route::resource('contactos',  ContactoController::class)->names('contacto');
    //IMPORTAR CONTACTOS
    Route::post('importar-contactos/{id}', [ContactoController::class, 'importarContactos'])->name('contactos.import');
    //CAMPAHAS
    Route::resource('broadcast',  CampanaController::class)->names('campana');
    Route::get('broadcast-makemessage/{id}', [CampanaController::class, 'makeMessage'])->name('campana.makemessage');
    Route::post('broadcast-makemessage/{id}', [CampanaController::class, 'sendmensajewhatsap'])->name('campana.sendmensajewhatsap');
});