<?php

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
Route::get('device/search', 'DevicesController@search')->name('device.search');
Route::post('device/display', 'DevicesController@display')->name('device.display');
Route::get('device/display', 'DevicesController@display');
Route::get('device/category/{cat}', 'DevicesController@category')->name('device.category');
Route::get('device/export', 'DevicesController@exportxls')->name('device.exportxls');
Route::get('admin/categories', 'DevicesController@addCategoryForm')->name('device.addCatF');
Route::post('admin/categories', 'DevicesController@addCategoryPost')->name('device.addCatP');
Route::post('admin/categories/del', 'DevicesController@deleteCategory')->name('device.deleteCat');
Route::resource('device', 'DevicesController');


Route::get('admin/search', 'UsersController@search')->name('admin.search');
Route::post('admin/display', 'UsersController@display')->name('admin.display');
Route::get('admin/display', 'UsersController@display');
Route::resource('admin', 'UsersController');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');

Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');