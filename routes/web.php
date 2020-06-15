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

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@home')->name('home');
Route::post('/', 'HomeController@store')->name('store');
Route::get('/home', 'HomeController@home')->name('home');

Route::get('/test', 'HomeController@test')->name('test');
Route::post('/test', 'HomeController@store')->name('test-store');
