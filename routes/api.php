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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/tasks', 'TaskController@getAll');

Route::post('/task', 'TaskController@create');

Route::delete('/task/{task}', 'TaskController@delete');

Route::match(['put', 'patch'],'/task/{task}', 'TaskController@update');

Route::match(['put', 'patch'],'/task/{task}/completed', 'TaskController@completed');
