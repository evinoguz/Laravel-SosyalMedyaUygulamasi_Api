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
        Route::get('profile/{id}','Api\ProfileController@profile');
        Route::post('post','Api\PostController@post');
        Route::get('follow_follower','Api\Follow_FollowerController@follow_follower');

    });

    Route::group(['prefix' => 'profile'], function () {

    });

    Route::group(['prefix' => 'post'], function () {

    });

    Route::group(['prefix' => 'follow_follower'], function () {

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

