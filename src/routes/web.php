<?php
	Route::group(['prefix' => 'bageur/v1/auth'], function () {
		Route::post('login', 'bageur\auth\AuthController@login')->middleware('guest');
		Route::delete('logout', 'bageur\auth\AuthController@logout')->middleware('jwt.verify');
		Route::post('refresh', 'bageur\auth\AuthController@refresh')->middleware('jwt.verify');
		Route::post('me', 'bageur\auth\AuthController@me')->middleware('jwt.verify');

	});


	Route::get('bageur/v1/global/menu', 'bageur\auth\MenuController@menufull')->middleware('jwt.verify');
