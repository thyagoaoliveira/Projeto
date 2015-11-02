<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', 'ClientController@index');