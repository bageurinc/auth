<?php
	Route::name('bageur.')->group(function () {
	Route::group(['prefix' => 'bageur/v1/auth'], function () {
		Route::post('login', 'bageur\auth\AuthController@login')->middleware('guest');
		Route::delete('logout', 'bageur\auth\AuthController@logout')->middleware('jwt.verify');
		Route::post('refresh', 'bageur\auth\AuthController@refresh')->middleware('jwt.verify');
		Route::post('me', 'bageur\auth\AuthController@me')->middleware('jwt.verify');

	});

		Route::group(['prefix' => 'bageur/v1'], function () {
			Route::apiResource('menu', 'bageur\auth\MenuController')->middleware('jwt.verify');
			Route::apiResource('user', 'bageur\auth\UserController')->middleware('jwt.verify');
			Route::get('menu-showseo/{link}', 'bageur\auth\MenuController@showseo')->middleware('jwt.verify');
			Route::post('menu-up-urutan', 'bageur\auth\MenuController@urutankan')->middleware('jwt.verify');
			Route::post('menu/ubahstatus', 'bageur\auth\MenuController@ubahstatus')->middleware('jwt.verify');
			Route::get('global/menu', 'bageur\auth\MenuController@menufull');
			Route::get('global/notif', 'bageur\auth\MenuController@notif');
			Route::get('global/notif/{id}', 'bageur\auth\MenuController@notif_detail');
		});

	});

