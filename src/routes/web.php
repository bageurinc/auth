<?php
	Route::name('bageur.')->group(function () {
	Route::group(['prefix' => 'bageur/v1/auth'], function () {
		Route::post('login', 'bageur\auth\controller\AuthController@login')->middleware('guest');
        Route::post('forgot/create', 'bageur\auth\controller\PasswordResetController@create')->middleware('guest');
        Route::get('find/{token}', 'bageur\auth\controller\PasswordResetController@find')->middleware('guest');
        Route::post('reset', 'bageur\auth\controller\PasswordResetController@reset')->middleware('guest');
		Route::delete('logout', 'bageur\auth\controller\AuthController@logout')->middleware('bgr.verify');
		Route::post('refresh', 'bageur\auth\controller\AuthController@refresh')->middleware('bgr.verify');
        Route::post('me', 'bageur\auth\controller\AuthController@me')->middleware('bgr.verify');
        Route::post('deviceregister', 'bageur\auth\controller\AuthController@device_add');
	});

		Route::group(['prefix' => 'bageur/v1'], function () {
			Route::get('p-upload/group/{folder}/{id}', 'bageur\auth\controller\PerkakasController@getgroup_p_upload');
			Route::post('p-upload', 'bageur\auth\controller\PerkakasController@p_upload');
			Route::delete('p-upload/{id}', 'bageur\auth\controller\PerkakasController@delete_p_upload');

			Route::apiResource('menu', 'bageur\auth\controller\MenuController')->middleware('bgr.verify');
			Route::apiResource('user', 'bageur\auth\controller\UserController')->middleware('bgr.verify');
			Route::apiResource('level', 'bageur\auth\controller\LevelController')->middleware('bgr.verify');
			Route::apiResource('menu.action', 'bageur\auth\controller\MenuActionController')->middleware('bgr.verify');
			Route::get('bageur-akses/{id}', 'bageur\auth\controller\LevelController@bageur_akses')->middleware('bgr.verify');
			Route::post('level-setup/{id}', 'bageur\auth\controller\LevelController@setup')->middleware('bgr.verify');

			Route::get('menu-showseo/{link}', 'bageur\auth\controller\MenuController@showseo')->middleware('bgr.verify');
			Route::post('menu-up-urutan', 'bageur\auth\controller\MenuController@urutankan')->middleware('bgr.verify');
			Route::post('menu/ubahstatus', 'bageur\auth\controller\MenuController@ubahstatus')->middleware('bgr.verify');
			Route::get('global/menu', 'bageur\auth\controller\MenuController@menufull');
			Route::get('global/notif', 'bageur\auth\controller\MenuController@notif');
			Route::get('global/notif/{id}', 'bageur\auth\controller\MenuController@notif_detail');
		});

	});

