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

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

//Route::get('/profile', 'UserController@profile');
//Route::post('/profile', 'UserController@updateAvatar');

Route::get('/', 'HomeController@welcome')->name('welcome');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/auth/{provider}', 'Auth\RegisterController@redirectToProvider');
Route::get('/auth/{provider}/callback', 'Auth\RegisterController@handleProviderCallback');


Route::get('/posts', 'PostController@index');


Route::prefix('users')->group(function () {
    Route::get('/','UserController@index')->name('users_list');
    Route::get('/{id}','UserController@user')->where('id', '\d+')->name('users_user');
    Route::post('/get-user-posts', 'UserController@getUserPosts')->name('users_get_user_posts');
    Route::post('/get-user-feeds', 'UserController@getUserFeeds')->name('users_get_user_feeds');

    Route::get('/favorites', 'UserController@favorites')->name('users_favorites');
    Route::post('/get-user-favorites-posts', 'UserController@getUserFavoritesPosts')->name('users_get_user_favorites_posts');
    Route::get('/profile', 'UserController@editprofile')->name('users_edit_profile');
    Route::post('/profile', 'UserController@updateProfile')->name('users_update_profile');

    Route::post('/follow', 'UserController@follow')->name('users_follow');
    Route::post('/unfollow', 'UserController@unfollow')->name('users_unfollow');
});

Route::prefix('posts')->group(function () {
    Route::post('/add-to-favorites', 'PostController@addToFavorites')->name('posts_addtofavorites');
    Route::post('/remove-from-favorites', 'PostController@removeFromFavorites')->name('posts_removefromfavorites');
    Route::post('/publish', 'PostController@publish')->name('posts_publish');
});
