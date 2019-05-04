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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('meal')->name('meal.')->group(function () {
    Route::get('/', 'MealController@index')->name('index');

    Route::post('/', 'MealController@store')->name('store');

    Route::delete('/{id}', 'MealController@deleteMeal')->name('deleteMeal');

    Route::get('/{id}/edit', 'MealController@show')->name('index');

    Route::post('/{id}/edit', 'ProductController@store')->name('storeProducts');

    Route::delete('/{meal_id}/{product_id}', 'MealController@deleteProduct')->name('deleteProduct');

});

Route::get('/show5HigherCal', 'StatisticsController@show5HigherCal')->name('show5HigherCal');

Route::get('/show5LowerCal', 'StatisticsController@show5LowerCal')->name('show5LowerCal');
Route::get('/show5HigherCalTotal', 'StatisticsController@show5HigherCalTotal')->name('show5HigherCalTotal');