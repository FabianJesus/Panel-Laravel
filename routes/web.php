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
Route::get('/clientes', 'ClientsController@index')->name('client');
Route::get('/clientes/{id}', 'ClientsController@getClient');
Route::get('/trabajos/borrar/{id}', 'WorksController@deletejob');
Route::get('/trabajos/{id}', 'WorksController@getjob');
Route::get('/mail/{id}', 'MailController@index');
Route::get('/trabajos/filtroFecha/{fecha}', 'WorksController@filterDate');

Route::post('/trabajos/filtroNombre', 'WorksController@filterName');
Route::post('/newClient', 'ClientsController@storeClient')->name('newClient');
Route::post('/newJob', 'WorksController@storeJob')->name('newJob');
Route::post('/mail/send', 'MailController@sendMail')->name('send');
Route::put('/cliente/{id}', 'ClientsController@editClient');

Route::get('Evento/form','ControllerEvent@form');
Route::post('Evento/create','ControllerEvent@create');
Route::get('Evento/details/{id}','ControllerEvent@details');
Route::get('Evento/index','ControllerEvent@index')->name('calendar');
Route::get('Evento/index/{month}','ControllerEvent@index_month');
Route::get('Evento/delete/{id}','ControllerEvent@delete');
Route::post('Evento/calendario','ControllerEvent@calendario');