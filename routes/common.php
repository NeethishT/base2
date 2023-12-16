<?php

use Illuminate\Support\Facades\Route;

Route::get('/su/login', 'AuthController@login')->name('login');
Route::post('/su/login', 'AuthController@validateLogin');
Route::get('/su/forgot-password', 'AuthController@forgotPassword')->middleware('guest')->name('reset.request');
Route::post('/su/reset-password', 'AuthController@resetPasswordLink')->middleware('guest')->name('reset.resetlink');
Route::get('/su/user-reset-password/{token}', 'AuthController@showResetPasswordForm')->name('reset.password');
Route::get('/su/submit-reset-password', 'AuthController@submitResetPasswordForm')->name('reset.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', 'AuthController@logout')->name('cms.users.logout');
    # Dashboard
    Route::get('/dashboard', 'DashboardController@dashboard')->name('cms.users.dashboard')->middleware('access:cms.users.dashboard');
});
