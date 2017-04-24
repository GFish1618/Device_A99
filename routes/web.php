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
Route::get('device/search/option', 'DevicesController@search')->name('device.search');
Route::post('device/search/display', 'DevicesController@display')->name('device.display');
Route::get('device/search/display', 'DevicesController@display');

Route::get('device/category/{cat}', 'DevicesController@category')->name('device.category');

Route::get('device/export', 'DevicesController@exportxls')->name('device.exportxls');
Route::get('device/52830473571418', 'DevicesController@reset')->name('device.reset');

Route::get('device/importxls', function (){ return view('devices/import'); });
Route::post('device/importxls', 'DevicesController@importxls')->name('device.importxls');

Route::get('device/gdrive', 'DevicesController@import_gdrive')->name('device.gdrive');

Route::post('device/indexPage', 'DevicesController@itemPerPages')->name('device.indexPage');
Route::post('device/indexOrder', 'DevicesController@orderByChange')->name('device.indexOrder');

Route::resource('device', 'DevicesController');

Route::get('admin/search/option', 'UsersController@search')->name('admin.search');
Route::post('admin/search/display', 'UsersController@display')->name('admin.display');
Route::get('admin/search/display', 'UsersController@display');

Route::resource('admin', 'UsersController');

Route::get('categories/list', 'CategoriesController@list_sidebar')->name('categories.list');
//Route::get('categories/test', 'CategoriesController@list_array');
Route::get('categories/fields/{mode}/{id}', 'CategoriesController@getFields');

Route::resource('categories', 'CategoriesController');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/', 'HomeController@index');

Route::get('login/google', 'Auth\LoginController@redirectToProvider');
Route::get('login/google/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('google/logout', 'UsersController@googleLogout');


