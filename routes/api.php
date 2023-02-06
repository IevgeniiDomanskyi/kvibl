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
Route::namespace('Api')->prefix('v1')->group(function() {
    Route::get('version', function() {
        return ['data' => config('app.version')];
    });

    Route::get('locale', 'LocaleController@all');
    Route::get('locale/{locale}', 'LocaleController@get');

    Route::post('preregister', 'AuthController@pre_register');
    Route::post('me', 'AuthController@me');
    Route::post('recovery', 'AuthController@recovery');
    Route::post('password/{hash:hash}', 'AuthController@password');
    Route::get('hash/{hash:hash}', 'AuthController@hash');
    Route::get('activate/{hash:hash}', 'AuthController@activate');

    Route::middleware('auth:sanctum')->group(function() {

        Route::prefix('game')->group(function() {
            Route::post('/', 'GameController@create');
            Route::post('connect', 'GameController@connect');
            Route::get('last', 'GameController@last');
            Route::prefix('{game}')->middleware('game')->group(function() {
                Route::prefix('player')->group(function() {
                    Route::prefix('{player}')->group(function() {
                        Route::post('login', 'AuthController@login');
                        Route::get('logout', 'AuthController@logout');
                        Route::post('register', 'UserController@register');

                        Route::get('push', 'PlayerController@push');

                        Route::post('update', 'PlayerController@update');
                        Route::post('online', 'PlayerController@online');
                        Route::post('prepare', 'PlayerController@prepare');
                        Route::post('tab', 'PlayerController@tab');
                        Route::delete('leave', 'PlayerController@leave');
                        Route::get('finish', 'PlayerController@finish');
                        Route::get('confirm', 'PlayerController@confirm');
                        Route::get('awards', 'PlayerController@awards');
                        Route::delete('remove/{removingPlayer}', 'PlayerController@remove');
                        Route::post('add/{addingPlayer}', 'PlayerController@add');

                        Route::prefix('word')->group(function() {
                            Route::prefix('{word}')->group(function() {
                                Route::get('view', 'WordController@view');
                                Route::get('approve', 'WordController@approve');
                                Route::get('confirm/{is_confirm}', 'WordController@confirm');
                            });

                            Route::get('/', 'WordController@get');
                        });

                        Route::prefix('virus')->group(function() {
                            Route::get('/', 'VirusController@get');
                            Route::get('random/{position}', 'VirusController@random');
                            Route::post('{virus}/apply', 'VirusController@apply');
                        });
                    });

                    Route::get('/', 'PlayerController@get');
                });

                Route::prefix('team')->group(function() {
                    Route::get('/', 'TeamController@get');
                });

                Route::get('/', 'GameController@get');
                Route::delete('/', 'GameController@remove');
                Route::get('forget', 'GameController@forget');
                Route::post('start', 'GameController@start');
                Route::get('me', 'GameController@me');
            });
        });

        Route::prefix('action')->group(function() {
            Route::get('{player}', 'ActionController@get');
            Route::post('{player}', 'ActionController@add');
            Route::delete('{action}', 'ActionController@remove');
        });

        Route::prefix('category')->group(function() {
            Route::get('/', 'CategoryController@all');
            Route::prefix('{category}')->group(function() {
                Route::get('/', 'CategoryController@get');
                Route::post('/{lang}', 'CategoryController@assign');
            });
        });

        Route::post('locale/{locale}', 'LocaleController@set');
        Route::post('settings', 'UserController@settings');

        Route::get('virus', 'VirusController@all');

        Route::post('upload_image', 'UploadController@upload_image');

    });

    Route::get('text/{locale?}', 'TextController@get');
});
