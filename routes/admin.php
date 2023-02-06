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

Route::namespace('Admin')->prefix('v1')->group(function() {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('me', 'AuthController@me');

        // #categories
        Route::get('category', 'CategoryController@all');
        Route::get('category/export', 'CategoryController@export');
        Route::get('category/{id}', 'CategoryController@get');
        Route::post('category/add', 'CategoryController@add');
        Route::delete('category', 'CategoryController@delete');
        Route::post('category/upload', 'CategoryController@uploadImportFile');
        Route::post('category/import', 'CategoryController@import');

        // #words
        Route::get('words/{id}', 'WordController@all');
        Route::post('words/add', 'WordController@add');
        Route::delete('words', 'WordController@delete');
        Route::put('words', 'WordController@update');
        Route::post('words/reset/{id}', 'WordController@reset');

        // #users
        Route::get('users', 'UsersController@all');
        Route::post('users/add', 'UsersController@add');
        Route::delete('users', 'UsersController@delete');
        Route::put('users', 'UsersController@update');

        // #locales
        Route::get('locale', 'LocaleController@all');

        // #langs
        Route::get('langs', 'LangController@all');
    });
});
