<?php
	Route::name('bageur.')->group(function () {
	Route::group(['prefix' => 'bageur/v1/auth'], function () {
		Route::post('login', 'bageur\auth\AuthController@login')->middleware('guest');
        Route::post('forgot/create', 'bageur\auth\PasswordResetController@create')->middleware('guest');
        Route::get('find/{token}', 'bageur\auth\PasswordResetController@find')->middleware('guest');
        Route::post('reset', 'bageur\auth\PasswordResetController@reset')->middleware('guest');
        
		Route::delete('logout', 'bageur\auth\AuthController@logout')->middleware('bgr.verify');
		Route::post('refresh', 'bageur\auth\AuthController@refresh')->middleware('bgr.verify');
        Route::post('me', 'bageur\auth\AuthController@me')->middleware('bgr.verify');
	});

		Route::group(['prefix' => 'bageur/v1'], function () {
			Route::get('indonesia/provinsi', 'bageur\auth\IndonesiaController@provinsi')->middleware('bgr.verify');
			Route::get('indonesia/provinsi/{id}', 'bageur\auth\IndonesiaController@provinsi_detail')->middleware('bgr.verify');

			Route::apiResource('menu', 'bageur\auth\MenuController')->middleware('bgr.verify');
			Route::apiResource('user', 'bageur\auth\UserController')->middleware('bgr.verify');
			Route::apiResource('level', 'bageur\auth\LevelController')->middleware('bgr.verify');
			Route::apiResource('menu.action', 'bageur\auth\MenuActionController')->middleware('bgr.verify');
			Route::get('bageur-akses/{id}', 'bageur\auth\LevelController@bageur_akses')->middleware('bgr.verify');
			Route::post('level-setup/{id}', 'bageur\auth\LevelController@setup')->middleware('bgr.verify');

			Route::get('menu-showseo/{link}', 'bageur\auth\MenuController@showseo')->middleware('bgr.verify');
			Route::post('menu-up-urutan', 'bageur\auth\MenuController@urutankan')->middleware('bgr.verify');
			Route::post('menu/ubahstatus', 'bageur\auth\MenuController@ubahstatus')->middleware('bgr.verify');
			Route::get('global/menu', 'bageur\auth\MenuController@menufull');
			Route::get('global/notif', 'bageur\auth\MenuController@notif');
			Route::get('global/notif/{id}', 'bageur\auth\MenuController@notif_detail');
		});

	});

