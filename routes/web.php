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

Route::get('admin/', "AdminController@Index")->name('admin_index');
Route::post('admin/new', "TestController@Newtest")->name('new_test');
Route::get('admin/tests', "TestController@New_question")->name('new_question');
Route::get('admin/testing', "AdminController@addTesting")->name('new_testing');

Route::get("admin/test/get/all", "TestController@getAllTests");

