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
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');
Route::get('open', 'DataController@open');
Route::get('login', 'UserController@authenticate')->name('login');

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('products', 'ProductController@index');
    Route::post('products', 'ProductController@store');
    Route::post('products/{product}', 'ProductController@update');
    Route::delete('products/{product}', 'ProductController@destroy');

    Route::get('user', 'UserController@getAuthenticatedUser');
    Route::get('closed', 'DataController@closed');
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
