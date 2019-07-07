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

Route::get('/', function () { return view('login'); });
Route::post('/register', 'RegisterController@register');

//PROFILE
Route::get('/profile/get-datas', 'ProfileController@getDatas');
Route::post('/profile/save', 'ProfileController@save');

//FOOD LIST
Route::get('/food-list/get-datas', 'FoodListController@getDatas');
Route::post('/food-list/new', 'FoodListController@store');
Route::post('/food-list/edit/{id}', 'FoodListController@update');
Route::get('/food-list/destroy/{id}', 'FoodListController@destroy');
Route::post('/food-list/destroy-selected', 'FoodListController@destroySelected');

//FOOD DIARY
Route::post('/food-diary/get-datas', 'FoodDiaryController@getDatas');
Route::post('/food-diary/add', 'FoodDiaryController@add');
Route::get('/food-diary/destroy/{id}', 'FoodDiaryController@destroy');

Route::get('/{any}', 'RouterController@index')->where('any', '.*');

