<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('client', function(){
	return \Projeto\Client::all();
});