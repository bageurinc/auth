<?php
	Route::name('bageur.')->group(function () {
	Route::group(['prefix' => 'bageur/v1/auth'], function () {
		Route::post('login', 'bageur\auth\AuthController@login')->middleware('guest');
		Route::delete('logout', 'bageur\auth\AuthController@logout')->middleware('jwt.verify');
		Route::post('refresh', 'bageur\auth\AuthController@refresh')->middleware('jwt.verify');
		Route::post('me', 'bageur\auth\AuthController@me')->middleware('jwt.verify');

	});

		Route::group(['prefix' => 'bageur/v1'], function () {
			Route::apiResource('user', 'bageur\auth\UserController');
			Route::get('global/menu', 'bageur\auth\MenuController@menufull');
		});

	});

