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
        Route::post('profile','Api\ProfileController@create');

    });

    Route::group(['prefix' => 'post'], function () {
        Route::post('post','Api\PostController@create');
        Route::get('remove','Api\PostController@remove');
        Route::post('updatePost','Api\PostController@updatePost');

    });

    Route::group(['prefix' => 'follow_follower'], function () {
        Route::get('follow_follower','Api\Follow_FollowerController@follow_follower');

    });

    Route::group(['prefix' => 'message'], function () {

    });

    Route::group(['prefix' => 'like'], function () {
        Route::post('create_like','Api\LikeController@create');
        Route::get('get_likes','Api\LikeController@getLike');
        Route::post('delete_like/{id}','Api\LikeController@delete');
    });

    Route::group(['prefix' => 'notification'], function () {

    });

    Route::group(['prefix' => 'comment'], function () {
        Route::post('create_comment','Api\CommentController@create');
        Route::get('get_comments','Api\CommentController@getComments');
        Route::post('delete_comment/{id}','Api\CommentController@delete');
        Route::post('update_comment/{id}','Api\CommentController@updateComment');
    });
=======
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
>>>>>>> 7c4b84da3d681972a2a132b67944341047d2e528

});

