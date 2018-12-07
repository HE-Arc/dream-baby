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
    // Profil routes
    Route::get('/profil', 'ProfilController@myprofil')->name('profil.myprofil');
    Route::get('/profil/{id}', 'ProfilController@profil')->name('profil.profil');

    // Donor specific routes
    Route::get('/donor/{id}/questions', 'DonorController@questions')->name('donor.questions');
    Route::get('/donor/questions', 'DonorController@myquestions')->name('donor.myquestions');
    Route::get('/donor/image/{filename}', 'DonorController@image')->name('donor.image');
    Route::patch('/donor/profil/update/{id}', 'DonorController@update')->name('donor.myprofil.update');
    
    // Seeker specific routes
    Route::patch('/seeker/profil/update/{id}', 'SeekerController@update')->name('seeker.myprofil.update');

    // Swipe routes
    Route::get('/seeker/search', 'SwipeController@search')->name('search');
    Route::post('/seeker/deletehistory','SwipeController@deleteSwipeHistory')->name('swipe.deletehistory');
    Route::post('/seeker/swipe','SwipeController@addToSwipeHistory')->middleware('ajax');
    Route::get('/seeker/swipe/next','SwipeController@getRandomDonorProfil')->middleware('ajax');
    Route::get('/swipes/history', 'SwipeController@history')->name('swipe_history');

    // Questions routes
    Route::get('questions', 'QuestionAnswerController@myquestions')->name('questions.myquestions');
    Route::get('questions/{id}', 'QuestionAnswerController@questions')->name('questions.donor');
    Route::post('questions/ask/{id}', 'QuestionAnswerController@create_question')->name('questions.ask');
    Route::post('questions/reply/{id}', 'QuestionAnswerController@create_reply')->name('questions.reply');
    Route::get('questions/delete/{id}', 'QuestionAnswerController@deleteQuestion')->name('questions.delete');
    Route::get('questions/delete_all', 'QuestionAnswerController@deleteAllQuestions')->name('questions.delete.all');

});
