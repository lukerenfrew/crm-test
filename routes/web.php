<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Auth::routes(['register' => false, 'confirm' => false]);
});

Route::get('/', HomeController::class)->name('home');
