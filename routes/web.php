<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/', 'HomeController@getUserProfile')->name('home');
Route::get('/home', 'HomeController@getUserProfile')->name('home');

Route::get('/user-profile', 'HomeController@getUserProfile')->name('user-profile');

Route::get('/user-profile-edit', 'HomeController@editUserProfile')->name('user-profile-edit');
Route::post('/user-profile-save', 'HomeController@editUserSave')->name('user-profile-save');

Route::post('/create-user', 'HomeController@createUser')->name('create-user');