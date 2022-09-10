<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::prefix('backend')->group(function () {
    Route::get('/home', 'backend\HomeController@index')->name('home');
    Route::get('/edit-profile', 'backend\HomeController@editprofile')->name('editprofile');
    Route::post('/edit-profile/{id}', 'backend\HomeController@aksieditprofile');

    Route::resource('/roles','backend\rolesController');
    Route::get('/data-roles','backend\rolesController@listdata');
    
    Route::get('/data-admin','backend\AdminController@listdata');
    Route::resource('/admin','backend\AdminController');
    Route::get('/web-setting', 'backend\HomeController@websetting');
    Route::post('/web-setting', 'backend\HomeController@updatewebsetting');

    Route::resource('/pegawai', 'backend\PegawaiController');
    Route::get('/data-pegawai','backend\PegawaiController@listdata');

    Route::resource('/divisi', 'backend\DivisiController');
    Route::get('/data-divisi','backend\DivisiController@listdata');

    Route::resource('/jabatan', 'backend\JabatanController');
    Route::get('/data-jabatan','backend\JabatanController@listdata');

    Route::resource('/shift', 'backend\ShiftController');
    Route::get('/data-shift','backend\ShiftController@listdata');
});
