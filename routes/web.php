<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/login");

Route::resource('/login', LoginController::class)->only(('index'));
Route::resource('/home', HomeController::class)->only(('index'));
