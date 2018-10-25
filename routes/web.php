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

/*Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/donor', 'DonorController@index')->name('donor.home');

Route::get('/seeker', 'SeekerController@index')->name('seeker.home');
Route::get('/seeker/search', 'SeekerController@search')->name('search');
Route::get('/seeker/criteria', 'SeekerController@criteria')->name('seeker.criteria');

