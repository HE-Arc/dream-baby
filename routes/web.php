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

Route::group(['middleware' => ['auth']], function () {
    Route::get('/profil', 'ProfilController@myprofil')->name('profil.myprofil');
    Route::get('/profil/{id}', 'ProfilController@profil')->name('profil.profil');

    Route::get('/donor/{id}/questions', 'DonorController@questions')->name('donor.questions');
    Route::get('/donor/questions', 'DonorController@myquestions')->name('donor.myquestions');
    Route::get('/donor/image/{filename}', 'DonorController@image')->name('donor.image');
    Route::patch('/donor/profil/update/{id}', 'DonorController@update')->name('donor.myprofil.update');
    
    Route::get('/seeker/search', 'SeekerController@search')->name('search');
    Route::patch('/seeker/profil/update/{id}', 'SeekerController@update')->name('seeker.myprofil.update');

    Route::post('/seeker/swipe','SeekerController@addToSwipeHistory')->middleware('ajax');
    Route::get('/seeker/swipe/next','DonorController@getRandomDonorProfil')->middleware('ajax');

    Route::get('/seeker/deletehistory','SeekerController@deleteSwipeHistory');
    Route::get('/donor/deletequestion/{id}','DonorController@deleteQuestion');

    Route::post('/donor/ask/{id}','DonorController@ask');
    Route::post('/donor/reply','DonorController@reply');

    Route::get('donor/deleteallquestions','DonorController@deleteAllQuestions');
});
