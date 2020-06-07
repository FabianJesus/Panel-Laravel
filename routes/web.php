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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/trabajos', 'WorksController@index')->name('works');
Route::get('/cliente/{id}', 'ClientsController@getClient');

Route::post('/newClient', 'WorksController@storeClient')->name('newClient');
Route::post('/newJob', 'WorksController@storeJob')->name('newJob');

