<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'AuthController@getLogin')->middleware('guest');

// Authentication Routes
Route::get('/login', 'AuthController@getLogin')->name('login')->middleware('guest');
Route::post('/login', 'AuthController@postLogin');
Route::get('/logout', 'AuthController@logout');

// Human Resource Routes
Route::middleware(['auth', 'hr'])->group(function () {
    Route::get('hr/dashboard', function () {
        return view('hr/dashboard');
    });
    Route::get('hr/kelola-akun', 'UserController@index');
});

// Users Routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('profile', function () {
        return view('user/profile');
    });
});
