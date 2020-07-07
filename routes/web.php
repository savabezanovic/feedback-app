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

Route::get('/', 'PageController@index')->name('home')->middleware('guest');
Route::get('/dashboard', 'PageController@dashboard')->name('user.dashboard');
Route::get('/profile/{id}', 'PageController@profile')->name('user.profile');
Route::get('/feedback', 'PageController@feedback')->name('user.feedback');
Route::get('/test-get', 'PageController@testGet')->name('user.testGet');
Route::get('/feedback/user/{id}', 'FeedbackController@getUser')->name('feedback.user');
Route::post('/feedback/store', 'FeedbackController@storeData')->name('feedback.store');

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

// SUPERADMIN

Route::get('/superadmin', 'SuperAdmin\SuperAdminController@index')->name('superadmin.index');
Route::get('/superadmin/companies', 'SuperAdmin\CompanyController@index')->name('superadmin.companies');
Route::get('/superadmin/admins', 'SuperAdmin\AdminController@index')->name('superadmin.admins');
Route::get('/superadmin/skills', 'SuperAdmin\SkillController@index')->name('superadmin.skills');
//Route::get('/admin/{id}', 'SuperAdmin\SuperAdminController@show')->name('superadmin.admin');

Route::post('/superadmin/companies', 'SuperAdmin\CompanyController@store')->name('company.store');
Route::get('/superadmin/companies/{id}/edit', 'SuperAdmin\CompanyController@edit')->name('company.edit');
Route::put('/superadmin/companies/{id}/update', 'SuperAdmin\CompanyController@update')->name('company.update');
Route::delete('/superadmin/companies/{id}/delete', 'SuperAdmin\CompanyController@destroy')->name('company.delete');

Route::post('/superadmin/skills', 'SuperAdmin\SkillController@store')->name('skill.store');
Route::put('/superadmin/skills/{id}/update', 'SuperAdmin\SkillController@update')->name('superadmin.skill.update');
Route::delete('/superadmin/skills/{id}/delete', 'SuperAdmin\SkillController@destroy')->name('superadmin.skill.delete');

Route::post('/superadmin/admins', 'SuperAdmin\AdminController@store')->name('admin.store');
Route::get('/superadmin/admins/{id}/update', 'SuperAdmin\AdminController@edit')->name('admin.edit');
Route::put('/superadmin/admins/{id}/update', 'SuperAdmin\AdminController@update')->name('admin.update');
Route::put('/superadmin/admins/{id}/update/password', 'SuperAdmin\AdminController@updatePassword')->name('admin.update-password');
Route::delete('/superadmin/users/{id}/delete', 'SuperAdmin\AdminController@destroy')->name('admin.delete');

Route::get('/superadmin/job-titles', 'SuperAdmin\JobTitleController@index');
Route::get('/superadmin/job-titles/paginated', 'SuperAdmin\JobTitleController@paginationFetchData');
Route::post('/superadmin/job-titles', 'SuperAdmin\JobTitleController@store')->name('job-title.store');
Route::put('/superadmin/job-titles/{id}', 'SuperAdmin\JobTitleController@update')->name('job-title.update');
Route::delete('/superadmin/job-titles/{id}', 'SuperAdmin\JobTitleController@destroy')->name('job-title.delete');

// ADMIN

Route::get('/admin', 'Admin\HomeController@index');

Route::get('/admin/users', 'Admin\UserController@index');
Route::post('/admin/users', 'Admin\UserController@store')->name('user.store');
Route::get('/admin/users/{id}', 'Admin\UserController@edit')->name('user.edit');
Route::put('/admin/users/{id}', 'Admin\UserController@update')->name('user.update');
Route::put('/admin/users/{id}/update/password', 'Admin\UserController@updatePassword')->name('user.update-password');
Route::delete('/admin/users/{id}', 'Admin\UserController@destroy')->name('user.delete');
Route::put('/admin/users/{id}/update/picture', 'Admin\UserController@updatePicture')->name('user.update-picture');
Route::put('/admin/users/{id}/update/status', 'Admin\UserController@updateStatus')->name('user.update-status');

Route::get('/admin/notification/create', 'Admin\UserNotificationController@index')->name('users.notify-all.create');
Route::post('/admin/notification/send', 'Admin\UserNotificationController@messageToAll')->name('users.notify-all.send');

Route::put('/admin/companies/{id}', 'Admin\CompanyController@update')->name('admin.company.update');

Route::get('/company/{id}', 'CompanyController@show')->name('company.show');
