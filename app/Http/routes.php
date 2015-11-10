<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientController@index');
Route::post('client', 'ClientController@store');
Route::get('client/{id}', 'ClientController@show');
Route::put('client/{id}', 'ClientController@update');
Route::delete('client/{id}', 'ClientController@destroy');

Route::get('project/{id}/note', 'ProjectNoteController@index');
Route::post('project/{id}/note', 'ProjectNoteController@store');
Route::get('project/{id}/note/{noteId}', 'ProjectNoteController@show');
Route::put('project/{id}/note/{noteId}', 'ProjectNoteController@update');
Route::delete('project/{id}/note/{noteId}', 'ProjectNoteController@destroy');

Route::get('project', 'ProjectController@index');
Route::post('project', 'ProjectController@store');
Route::get('project/{id}', 'ProjectController@show');
Route::put('project/{id}', 'ProjectController@update');
Route::delete('project/{id}', 'ProjectController@destroy');