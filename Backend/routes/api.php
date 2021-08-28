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

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::get('/organisations', 'Api\OrganisationController@index');
Route::post('/organisations', 'Api\OrganisationController@store');
Route::patch('/organisations/{organisation}', 'Api\OrganisationController@update');
Route::delete('/organisations/{organisation}', 'Api\OrganisationController@destroy');
