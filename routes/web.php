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
Route::get('/', "IndexController@Index");
Route::get('/chckTesting', "IndexController@chckUser")->name("chckUser");

Route::get('/welcome/{id}', 'IndexController@welcome')->name('welcome_page');
Route::get("/start/{id}", "TestController@start_test");
Route::get("/report/{id{", "QuestController@report_test");


Route::get('admin/', "AdminController@Index")->name('admin_index');
Route::get('admin/create/test', "AdminController@CreateTest")->name('create_test');
Route::post('admin/new', "TestController@Newtest")->name('new_test');

Route::get('admin/test/edit/{id}', "TestController@edit")->name('test_edit');
Route::post('admin/test/update/{id}', "TestController@update")->name('test_update');
Route::get('admin/test/list', "TestController@TestList")->name('test_list');

Route::get('admin/testing', "AdminController@addTesting")->name('new_testing');


Route::get("admin/test/get/all", "TestController@getAllTests");

Route::get("admin/test/set", "QuestionController@addAnswer");