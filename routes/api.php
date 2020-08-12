<?php


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

// Settings
Route::get('/settings', 'SettingController@index');
Route::get('/status', 'SettingController@status');
Route::get('/image/logo', 'SettingController@showLogo');
Route::get('/image/minilogo', 'SettingController@showMiniLogo');

// Movies
Route::get('/movies', 'MovieController@index');
Route::get('/movies/image/{filename}', 'MovieController@getImg');
Route::get('/movies/latest', 'MovieController@latest');
Route::get('/movies/recommended', 'MovieController@recommended');
Route::get('/movies/popular', 'MovieController@popular');
Route::get('/movies/recents', 'MovieController@recents');
Route::get('/movies/relateds/{movie}', 'MovieController@relateds');
Route::get('/movies/videos/{movie}', 'MovieController@videos');
Route::get('/movies/kids', 'MovieController@kids');
Route::get('/movies/view/{movie}', 'MovieController@view');
Route::get('/movies/show/{movie}', 'MovieController@show');

// Series
Route::get('/series', 'SerieController@index');
Route::get('/series/image/{filename}', 'SerieController@getImg');
Route::get('/series/show/{serie}', 'SerieController@show');
Route::get('/series/recommended', 'SerieController@recommended');
Route::get('/series/popular', 'SerieController@popular');
Route::get('/series/recents', 'SerieController@recents');
Route::get('/series/kids', 'SerieController@kids');
Route::get('/series/relateds/{serie}', 'SerieController@relateds');

// Seasons and Episodes
Route::get('/series/season/{season}', 'SeasonController@show');
Route::get('/series/episode/{episode}', 'EpisodeController@videos');
Route::get('/series/view/{episode}', 'EpisodeController@view');

// Live TV
Route::get('/livetv', 'LivetvController@index');
Route::get('/livetv/show/{livetv}', 'LivetvController@show');
Route::get('/livetv/image/{filename}', 'LivetvController@getImg');

//Genres 
Route::get('/genres', 'GenreController@index');
Route::get('/genres/movies/show/{genre}', 'GenreController@showMovies');
Route::get('/genres/series/show/{genre}', 'GenreController@showSeries');
Route::get('/genres/list', 'GenreController@list');

//Search
Route::get('/search/{query}', 'SearchController@index');

//Embeds
Route::get('/embeds/show/{embed}', 'EmbedController@show');

//Videos
Route::get('/video/{filename}', 'VideoController@show');
