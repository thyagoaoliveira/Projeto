<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('oauth/access_token', function() {
	return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function() {
	Route::resource('client', 'ClientController', ['except' => ['create', 'edit']]);

	Route::resource('project', 'ProjectController', ['except' => ['create', 'edit']]);

	Route::group(['prefix' => 'project'], function() {
		Route::get('{id}/note', 'ProjectNoteController@index');
		Route::post('{id}/note', 'ProjectNoteController@store');
		Route::get('{id}/note/{noteId}', 'ProjectNoteController@show');
		Route::put('{id}/note/{noteId}', 'ProjectNoteController@update');
		Route::delete('{id}/note/{noteId}', 'ProjectNoteController@destroy');

		//Route::get('{id}/task', 'ProjectTaskController@index');
		Route::get('task', 'ProjectTaskController@index');
		Route::post('{id}/task', 'ProjectTaskController@store');
		Route::get('{id}/task/{taskId}', 'ProjectTaskController@show');
		Route::put('{id}/task/{taskId}', 'ProjectTaskController@update');
		Route::delete('{id}/task/{taskId}', 'ProjectTaskController@destroy');

		Route::get('{id}/member', 'ProjectController@showMember');
		Route::post('{id}/member/{memberId}', 'ProjectController@addMember');
		Route::delete('{id}/member/{memberId}', 'ProjectController@removeMember');

		Route::post('{id}/file', 'ProjectFileController@store');
	});
});