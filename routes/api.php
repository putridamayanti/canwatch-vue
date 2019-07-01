<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'Api', 'middleware' => 'cors'], function (){
    Route::post('/login', 'AuthController@login');
    Route::get('/homepage', 'FrontController@index');
    Route::post('/drama/get', 'FrontController@getSeries');
//    Route::get('/movie/get', 'FrontController@getMovie');
    Route::get('/detail/{slug}', 'FrontController@detail');
//    Route::get('/series/episode/{seri}', 'Series\EpisodeController');

    Route::resource('category', 'CategoryController', ['names' => 'category']);
    Route::resource('country', 'CountryController', ['names' => 'country']);
    Route::resource('resource', 'ResourceController', ['names' => 'resource']);
    Route::resource('series', 'Series\SeriesController', ['names' => 'series']);
    Route::resource('playlist', 'Series\PlaylistController', ['names' => 'playlist']);
    Route::resource('episode', 'Series\EpisodeController', ['names' => 'episode']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
