<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'BookController@index');

Route::get('/add', 'BookController@add');

Route::post('/add', 'BookController@store');

Route::get('/books/{id}', 'BookController@show');

Route::get('/books/{id}/edit', 'BookController@edit');

Route::put('/books/{id}/update', 'BookController@update');

Route::delete('/books/{id}/delete', 'BookController@destroy');

Route::get('/bulkUpload', 'BookController@uploadFileShow');

Route::post('/bulkUpload', 'BookController@processCSVFile');

Route::get('/search', 'BookController@searchForm');

Route::get('/search', 'BookController@search');
