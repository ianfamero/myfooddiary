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

Route::get('/', 'LoginController@index')->name('login');
Route::post('/register', 'RegisterController@register');
Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['auth:web']], function() {
    
    //PROFILE
    Route::get('/profile/get-datas', 'ProfileController@getDatas');
    Route::post('/profile/save', 'ProfileController@save');

    //FOOD LIST
    Route::get('/food-list/get-datas', 'FoodListController@getDatas');
    Route::post('/food-list/new', 'FoodListController@store');
    Route::post('/food-list/edit/{id}', 'FoodListController@update');
    Route::get('/food-list/destroy/{id}', 'FoodListController@destroy');
    Route::post('/food-list/destroy-selected', 'FoodListController@destroySelected');
    Route::post('/food-list/external-food-databases/search', 'ExternalFoodDatabasesController@search');
    Route::post('/food-list/external-food-databases/new', 'ExternalFoodDatabasesController@store');


    //FOOD DIARY
    Route::post('/food-diary/get-datas', 'FoodDiaryController@getDatas');
    Route::post('/food-diary/add', 'FoodDiaryController@add');
    Route::get('/food-diary/destroy/{id}', 'FoodDiaryController@destroy');

    //REPORTS
    Route::post('/report/generate', 'ReportController@generate');

    Route::get('/{any}', 'RouterController@index')->where('any', '.*');
});