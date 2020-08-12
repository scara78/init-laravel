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

Auth::routes();

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/Auth/login', 'Auth\LoginController@login');
Route::get('/Auth/register', 'Auth\RegisterController@create');


Route::group(['middleware' => ['auth', 'activated', 'currentUser']], function () {
    // Admin Routes
    // Route::get('/', 'TorneiosController@index')->name('admin');

    // Route::get('/torneios', 'TorneiosController@show')->name('torneios');
    // Route::post('/torneios/create', 'TorneiosController@create')->name('torneios.create');
    // Route::get('/getTorneiosList', 'TorneiosController@getTorneiosList')->name('torneios.getTorneiosList');

    // Route::get('/torneios_content', 'TorneiosContentController@index')->name('torneios_content');
});


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    // Admin Routes
    Route::get('/', 'TorneiosController@index')->name('admin');

    Route::get('/torneios', 'TorneiosController@show')->name('torneios');
    Route::post('/torneios/create', 'TorneiosController@create')->name('torneios.create');
    Route::get('/getTorneiosList', 'TorneiosController@getTorneiosList')->name('torneios.getTorneiosList');

    Route::get('/torneios_content', 'TorneiosContentController@index')->name('torneios_content');


    // Route::get('/movies', 'AdminController@movies')->name('admin.movies');
    // Route::get('/series', 'AdminController@series')->name('admin.series');
    // Route::get('/livetv', 'AdminController@livetv')->name('admin.livetv');
    // Route::get('/servers', 'AdminController@servers')->name('admin.server');
    // Route::get('/genres', 'AdminController@genres')->name('admin.genres');
    // Route::get('/notifications', 'AdminController@notifications')->name('admin.notifications');
    // Route::get('/settings', 'AdminController@settings')->name('admin.settings');
    // Route::get('/account', 'AdminController@account')->name('admin.account');

    // // Dashboard
    // Route::get('/topmovies', 'AdminController@topmovies');
    // Route::get('/topseries', 'AdminController@topseries');
    // Route::get('/topepisodes', 'AdminController@topepisodes');
    // Route::get('/toplivetvs', 'AdminController@toplivetvs');

    // // Settings
    // Route::get('/settings/data', 'SettingController@data');
    // Route::put('/settings/update/{setting}', 'SettingController@update');
    // Route::post('/update/logo', 'SettingController@updateLogo');
    // Route::post('/update/minilogo', 'SettingController@updateMiniLogo');

    // // Account
    // Route::get('/account/data', 'UserController@data');
    // Route::put('/account/update', 'UserController@update');
    // Route::put('/account/password/update', 'UserController@passwordUpdate');

    // // Movies
    // Route::get('/movies/data', 'MovieController@data');
    // Route::post('/movies/store', 'MovieController@store');
    // Route::delete('/movies/destroy/{movie}', 'MovieController@destroy');
    // Route::post('/movies/image/store', 'MovieController@storeImg');
    // Route::put('/movies/update/{movie}', 'MovieController@update');
    // Route::delete('/movies/videos/destroy/{movievideo}', 'MovieController@videoDestroy');
    // Route::delete('/movies/genres/destroy/{moviegenre}', 'MovieController@destroyGenre');

    // //Series
    // Route::get('/series/data', 'SerieController@data');
    // Route::post('/series/store', 'SerieController@store');
    // Route::delete('/series/destroy/{serie}', 'SerieController@destroy');
    // Route::put('/series/update/{serie}', 'SerieController@update');
    // Route::post('/series/image/store', 'SerieController@storeImg');
    // Route::delete('/series/genres/destroy/{seriegenre}', 'SerieController@destroyGenre');

    // // Seasons And Episodes
    // Route::delete('/series/seasons/destroy/{season}', 'SeasonController@destroy');
    // Route::delete('/series/episodes/destroy/{episode}', 'EpisodeController@destroy');
    // Route::delete('/series/videos/destroy/{serievideo}', 'EpisodeController@destroyVideo');

    // // Livetv
    // Route::get('/livetv/data', 'LivetvController@data');
    // Route::post('/livetv/store', 'LivetvController@store');
    // Route::delete('/livetv/destroy/{livetv}', 'LivetvController@destroy');
    // Route::put('/livetv/update/{livetv}', 'LivetvController@update');
    // Route::post('/livetv/image/store', 'LivetvController@storeImg');

    // // Servers
    // Route::get('/servers/data', 'ServerController@data');
    // Route::post('/servers/store', 'ServerController@store');
    // Route::put('/servers/update/{server}', 'ServerController@update');
    // Route::delete('/servers/destroy/{server}', 'ServerController@destroy');

    // // Genres
    // Route::get('/genres/data', 'GenreController@data');
    // Route::post('/genres/store', 'GenreController@store');
    // Route::post('/genres/fetch', 'GenreController@fetch');
    // Route::delete('/genres/destroy/{genre}', 'GenreController@destroy');
    // Route::put('/genres/update/{genre}', 'GenreController@update');

    // // Videos 
    // Route::post('/video/store', 'VideoController@store');
});
