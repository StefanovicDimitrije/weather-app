<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GoogleAuthController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Google auth routes (guest/google)
Route::get('/guest/google/redirect','App\Http\Controllers\Api\GoogleAuthController@redirectToProvider')->name("api.google.redirect");
    // TODO This route *could* be a post
Route::get('/guest/google/callback','App\Http\Controllers\Api\GoogleAuthController@handleProviderCallback')->name("api.google.callback");

// OpenWeatherAPI related routes
Route::get('/weather/current/{city}/{token}','App\Http\Controllers\Api\OpenWeatherController@getTownCurrent')->name("api.openweather.current");
Route::get('/weather/forecast/{city}/{token}','App\Http\Controllers\Api\OpenWeatherController@getTownForecast')->name("api.openweather.forecast");
Route::get('/weather/current/{token}','App\Http\Controllers\Api\OpenWeatherController@getUserCurrent')->name('api.openweather.current.user');
Route::get('/weather/forecast/{token}','App\Http\Controllers\Api\OpenWeatherController@getUserForecast')->name('api.openweather.forecast.user');

// Search suggestions (Based on the cities in the db) route
Route::get('search/{term}','App\Http\Controllers\Api\SearchSuggestionsController@getSuggestions')->name('api.search.suggestions');
