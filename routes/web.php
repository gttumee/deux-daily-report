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


Route::get('/report', [DailyReportController::class, 'showForm'])->middleware('auth')->name('report.form');
Route::post('/report', [DailyReportController::class, 'store'])->middleware('auth')->name('report.store');
Route::get('/detail-report', [DailyReportController::class, 'show'])->middleware('auth')->name('detail-report');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');