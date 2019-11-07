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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//
//});


Route::group(['middleware' => 'api'], function () {
    Route::group(['prefix' => 'auth'], function () {



    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/profile','Api\ProfileController@get_profile');
        Route::get('/profile_edit','Api\ProfileController@edit_profile');


    });

    Route::group(['prefix' => 'post'], function () {
        Route::post('/post','Api\PostController@create');
        Route::get('/remove','Api\PostController@remove');
        Route::post('/updatePost','Api\PostController@updatePost');

    });

    Route::group(['prefix' => 'follow_follower'], function () {
        Route::get('/follow_follower','Api\Follow_FollowerController@create');
        Route::get('/remove_follow_follower','Api\Follow_FollowerController@remove');

    });

    Route::group(['prefix' => 'message'], function () {

    });

    Route::group(['prefix' => 'like'], function () {

    });

    Route::group(['prefix' => 'notification'], function () {

    });

    Route::group(['prefix' => 'comment'], function () {

    });

});

