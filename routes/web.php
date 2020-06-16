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

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', function () {
        return view('admin/dashboard');
    });

    Route::get('admin/akun/kelola-akun', 'UserController@index');
    Route::get('admin/akun/input-akun', 'UserController@create');
    Route::get('admin/akun/{employee}', 'EmployeeController@show');
    Route::post('admin/akun/input-akun', 'UserController@store');
    Route::patch('admin/akun/{id}', 'EmployeeController@updatePasswordFromAdmin');
    Route::delete('admin/akun/{id}', 'UserController@destroy');

    Route::get('admin/data-karyawan', 'EmployeeController@index');
    Route::get('admin/data-karyawan/{employee}', 'EmployeeController@show');
    Route::get('admin/data-karyawan/{employee}/edit', 'EmployeeController@editAdmin');
    Route::patch('admin/data-karyawan/{id}', 'EmployeeController@updateProfileFromAdmin');
});

// Users Routes
Route::middleware(['auth', 'user'])->group(function () {
    Route::get('profile', 'EmployeeController@profile');
    Route::get('profile/edit', 'EmployeeController@editUser');
    Route::patch('profile/update-password', 'EmployeeController@updatePassword');
    Route::patch('profile/update-profile', 'EmployeeController@updateProfile');
});
