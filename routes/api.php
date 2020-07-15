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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register', 'UserController@registration');
Route::post('login', 'UserController@authenticate');
//Route::get('open', 'DataController@open');

Route::group(['middleware' => 'jwt.verify'], function() {
    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::post('/events', 'EventController@store');
    Route::get('/events', 'EventController@index');
    Route::delete('/events/{id}', 'EventController@destroy');
    Route::put('/events/{id}/edit', 'EventController@edit'); 
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('logout', 'UserController@logout')->name('logout');
});
