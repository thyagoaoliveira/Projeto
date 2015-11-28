<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', function() {
	return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function() {
	Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);

	Route::group(['prefix' => 'project'], function() {
		Route::resource('', 'ProjectController', ['except' => ['create', 'edit']]);

		/*Route::get('{id}/note', 'ProjectNoteController@index');
		Route::post('{id}/note', 'ProjectNoteController@store');
		Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
		Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
		Route::delete('note/{noteId}', 'ProjectNoteController@destroy');*/
	});
});
