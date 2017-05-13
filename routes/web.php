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
/* voyager admin panel */
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Auth::routes();

Route::get('/', 'tmdbController@popularMovies')->name('popularMovies');
Route::get('/movie/{movie_id}', 'tmdbController@singleMovie')->name('singleMovie');
Route::get('/person/{person_id}', 'tmdbController@filmography')->name('filmography');
Route::get('/search', 'tmdbController@search')->name('search');

/* user dashboard */
Route::get('/dashboard', function(){
	return redirect('/');
})->name('dashboard');
// Route::get('/dashboard', 'HomeController@index')->name('dashboard');
// 
Route::get('/favs', 'FavouritesController@getAll')->name('favs');
Route::post('/savefav', 'FavouritesController@saveFavourite')->name('saveFav');



Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
