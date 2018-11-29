<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => 'auth'], function(){
Route::get('/', 'PostsController@index');
Route::post('skelbti-irasa', 'PostsController@post');
Route::get('patinka/{id}', 'LikesController@liked');
Route::post('komentuoti/{id}', 'CommentsController@comment');
Route::get('trinti-irasa/{id}', 'PostsController@delete');
Route::get('vartotojas/{id}/{username}', 'UserController@index');
Route::post('/atsakymas-i-komentara/{id}', 'CommentsController@reply');
Route::get('trinti-atsakyma/{id}', 'CommentsController@deleteReply');
Route::get('trinti-komentara/{id}', 'CommentsController@deleteComment');
Route::post('atnaujinti-informacija/{id}', 'UserController@update');
Route::post('keisti-slaptazodi/{id}', 'UserController@passwordChange');
Route::get('draugu-paieska', function(){
    return view('search.index');
});
Route::post('paieskos-rezultatai', 'SearchController@results');
Route::get('siusti-kvietima-draugauti/{id}/{username}', 'FriendsController@add');
Route::get('kvietimai-draugauti', 'FriendsController@showRequests');
Route::get('priimti-kvietima/{id}', 'FriendsController@accept');
Route::get('draugai/{username}/{id}', 'FriendsController@show');
Route::get('trinti-drauga/{id}/{username}', 'FriendsController@delete');
Route::get('patinka-komentaras/{id}', 'CommentsLikesController@like');
Route::get('patinka-atsakymas/{id}', 'LikesRepliesController@like');
Route::get('irasas/{id}', 'PostsController@show');
Route::get('irasai-su-zyme/{tag}', 'PostsController@postWithTag');
Route::get('pokalbiai', 'ChatController@index');
Route::post('siusti-pranesima', 'ChatController@send');
Route::post('siusti-zinute/{id}', 'ConversationController@store');
});

Route::auth();

// Authentication routes...
Route::get('prisijungti', 'Auth\AuthController@getLogin');
Route::post('prisijungti', 'Auth\AuthController@postLogin');


// Registration routes...
Route::get('registracija', 'Auth\AuthController@getRegister');
Route::post('registruotis', 'Auth\AuthController@postRegister');
