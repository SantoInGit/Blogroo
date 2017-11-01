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
});
*/

Route::get('/', 'PagesController@index');
Route::get('/about','PagesController@about');
Route::get('/services', 'PagesController@services');

//routes for PostsController
Route::resource('/posts','PostsController');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');


//routes for comments in CommentsController
Route::post('/posts/{post}/comments','CommentsController@store');

//routes for likes in LikesController
Route::post('/posts/{post}/likes','LikesController@store');
Route::delete('/likes/{post}','LikesController@destroy');

//routes for user profile

Route::get('/profile/create','ProfilesController@create');
Route::get('/profile/{profile}/edit','ProfilesController@edit');
Route::get('/profiles','ProfilesController@index');
Route::get('/profile/{profile}','ProfilesController@show');

Route::post('/profile','ProfilesController@store');

Route::put('/profile/{profile}','ProfilesController@update');
Route::delete('/profile/{profile}','ProfilesController@destroy');


//routes of FollowersController
//Route::resource('/followers','FollowersController');

Route::post('/followers/{profile}/follower','FollowersController@store');
Route::delete('/followers/{profile}','FollowersController@destroy');
