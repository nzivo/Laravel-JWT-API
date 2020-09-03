<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::get('logout', 'AuthController@logout');
Route::post('save_user_info', 'AuthController@saveUserInfo')->middleware('jwtAuth');

Route::apiResource('user', 'API\UserController');

Route::apiResource('category', 'API\CategoryController');
Route::group(['prefix'=>'category'],function(){
    Route::apiResource('/{category}/bookTypes','API\BookTypeController');
});

Route::apiResource('bookType', 'API\BookTypeController');
