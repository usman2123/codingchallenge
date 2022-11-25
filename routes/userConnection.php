<?php

use Illuminate\Support\Facades\Route;

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

Route::resource('network-connections', 'NetworkConnectionController');
Route::get('get-suggestions', 'NetworkConnectionController@getSuggestions');
Route::post('send-request', 'NetworkConnectionController@sendRequest');
Route::get('get-requests/{mode}', 'NetworkConnectionController@getRequests');
Route::post('delete-request', 'NetworkConnectionController@deleteRequest');
Route::post('accept-request', 'NetworkConnectionController@acceptRequest');
Route::get('get-connections', 'NetworkConnectionController@getConnections');
Route::get('get-counts', 'NetworkConnectionController@getCounts');