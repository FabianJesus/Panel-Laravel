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
Route::get('/trabajos/{id}', 'WorksController@deletejob');
Route::get('/mail/{id}', 'MailController@index');
Route::get('/filtro/fecha', 'WorksController@filterDate')->name('filtroFecha');

Route::post('/newClient', 'ClientsController@storeClient')->name('newClient');
Route::post('/newJob', 'WorksController@storeJob')->name('newJob');
Route::post('/mail/send', 'MailController@sendMail')->name('send');
Route::put('/cliente/{id}', 'ClientsController@editClient');
