<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false, 'confirm' => false]);

Route::get('/home', 'HomeController@index')->name('home');
