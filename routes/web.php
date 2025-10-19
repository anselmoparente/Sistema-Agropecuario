<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProdutorController;
use App\Http\Controllers\PropriedadeController;
use App\Http\Controllers\RebanhoController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\UnidadeProducaoController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::redirect('/', '/login');

    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});


Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('/produtores', ProdutorController::class);
    Route::resource('/propriedades', PropriedadeController::class);
    Route::resource('/rebanhos', RebanhoController::class);
    Route::resource('/unidades-producao', UnidadeProducaoController::class)->parameters(['unidades-producao' => 'up']);
    Route::get('/relatorios', [RelatorioController::class, 'index'])->name('relatorios');
    Route::get('/relatorios/exportar/propriedades-excel', [RelatorioController::class, 'exportarPropriedadesExcel'])->name('relatorios.export.propriedades.excel');
    Route::get('/relatorios/exportar/rebanhos-pdf', [RelatorioController::class, 'exportarRebanhosPdf'])->name('relatorios.export.rebanhos.pdf');
});
