<?php

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\EmployeeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('admin.dashboard');

Route::resource('/company', CompanyController::class);
Route::resource('/employee', EmployeeController::class);
