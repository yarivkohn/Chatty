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


/** Home  */
Route::get('/', [
    'uses' => '\Chatty\Http\Controllers\HomeController@index',
     'as' => 'home',
    ]
);

/** Authentication */
Route::get('/signup', [
    'uses' => '\Chatty\Http\Controllers\AuthController@getSignUp',
    'as' => 'auth.signup',
    'middleware' => ['guest'],
]);

Route::post('/signup',[
    'uses' => '\Chatty\Http\Controllers\AuthController@postSignUp',
    'middleware' => ['guest'],

]);


Route::get('/signin', [
    'uses' => '\Chatty\Http\Controllers\AuthController@getSignIn',
    'as' => 'auth.signin',
    'middleware' => ['guest'],
]);

Route::post('/signin',[
    'uses' => '\Chatty\Http\Controllers\AuthController@postSignIn',
    'middleware' => ['guest'],
]);

Route::get('/signout', [
    'uses' => '\Chatty\Http\Controllers\AuthController@getSignOut',
    'as' => 'auth.signout'
]);

/** Search */
Route::get('/search', [
    'uses' => '\Chatty\Http\Controllers\SearchController@getResults',
    'as' => 'search.results'

]);


/** User profile */
Route::get('/user/{username}', [
    'uses' => '\Chatty\Http\Controllers\ProfileController@getProfile',
    'as' => 'profile.index',
    'middleware' => ['auth'],
]);

Route::get('/profile/edit', [
    'uses' => '\Chatty\Http\Controllers\ProfileController@getEdit',
    'as' => 'profile.edit',
    'middleware' => ['auth'],
]);

Route::post('/profile/edit', [
    'uses' => '\Chatty\Http\Controllers\ProfileController@postEdit',
    'middleware' => ['auth'],
]);


/** Friends */
Route::get('/friends', [
    'uses' => '\Chatty\Http\Controllers\FriendController@getIndex',
    'as' => 'friend.index',
    'middleware' => ['auth'],
]);

Route::get('/friends/add/{username}', [
    'uses' => '\Chatty\Http\Controllers\FriendController@getAdd',
    'as' => 'friend.add',
    'middleware' => ['auth'],
]);

Route::get('/friends/accept/{username}', [
    'uses' => '\Chatty\Http\Controllers\FriendController@getAccept',
    'as' => 'friend.accept',
    'middleware' => ['auth'],
]);

Route::post('/friends/delete/{username}', [
	'uses' => '\Chatty\Http\Controllers\FriendController@postDelete',
	'as' => 'friend.delete',
	'middleware' => ['auth'],
]);


/** Statuses controller */
Route::post('/status', [
    'uses' => '\Chatty\Http\Controllers\StatusesController@postStatus',
    'as' => 'status.post',
    'middleware' => ['auth'],
]);

Route::post('/status/{statusId}/replay', [
	'uses' => '\Chatty\Http\Controllers\StatusesController@postReplay',
	'as' => 'status.replay',
	'middleware' => ['auth'],
]);


Route::get('/status/{statusId}/like', [
	'uses' => '\Chatty\Http\Controllers\StatusesController@getLike',
	'as' => 'status.like',
	'middleware' => ['auth'],
]);