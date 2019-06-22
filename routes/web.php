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

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// Item Routes
Route::get('/delete-product/{id}', 'HomeController@deleteItem')->name('home');
Route::post('/upload-item', 'HomeController@uploadItem')->name('home');
Route::post('/upload-msg', 'HomeController@uploadMsg')->name('home');
Route::get('/delete-msg/{id}', 'HomeController@deleteMsg')->name('home');
Route::get('/delete-time/{id}', 'HomeController@deleteTime')->name('home');

// User Routes
Route::get('/delete-user/{id}', 'HomeController@deleteUser')->name('home');
Route::get('/force-op/{id}', 'HomeController@forceOP')->name('home');
Route::get('/de-op/{id}', 'HomeController@deOP')->name('home');
Route::get('/delete-account/{id}', 'HomeController@deleteAccount')->name('home');
Route::get('/buy-item/{id}/{userId}', 'HomeController@buyItem')->name('home');

// Iphone API
Route::get('/loginios/{username}/{password}', 'IOSController@login');
Route::get('/showtimer/{user}', 'IOSController@showtimer');
Route::get('/showtimer/{user}/{id}', 'IOSController@showtimerdag');
Route::get('/showtimercount/{user}', 'IOSController@showtimercount');
Route::get('/addtimer/{userUrl}/{dateUrl}/{inTimeUrl}/{outTimeUrl}/{totalUrl}', 'IOSController@addtimer');

// ESP8266
Route::get('/esp', 'IOSController@esp');

