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

Route::get('admin/getCount', "TestController@test");
Route::get('admin/get', "TestController@GetQuestion");
Route::post('admin/question/new', "QuestionController@Newquestion");
Route::get("admin/test/get/{id}", "TestController@tests");
Route::get("admin/test/all", "TestController@getAllTests");
Route::get("admin/test/settings/get/{id}", "TestController@getSettings");
Route::post("admin/test/settings/save/{id}", "SettingsController@saveSettings");
Route::post("admin/test/add/user", "TstingController@addUser");


// user

Route::get("/test/get/{id}", "TestController@getTestforUser");
Route::post("/test/answer/{id}", "QuestionController@store");