<?php

use App\Http\Controllers\DailyReportController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/report');
    } else {
        return redirect('/login');
    }
});


Route::get('/report', [DailyReportController::class, 'create'])->middleware('auth');
Route::post('/report', [DailyReportController::class, 'store'])->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
