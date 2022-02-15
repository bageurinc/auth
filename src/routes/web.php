<?php
	Route::name('bageur.')->group(function () {
	Route::group(['prefix' => 'bageur/v1/auth'], function () {
		Route::post('login', 'Bageur\Auth\Controllers\AuthController@login')->middleware('guest');
        Route::post('forgot/create', 'Bageur\Auth\Controllers\PasswordResetController@create')->middleware('guest');
        Route::get('find/{token}', 'Bageur\Auth\Controllers\PasswordResetController@find')->middleware('guest');
        Route::post('reset', 'Bageur\Auth\Controllers\PasswordResetController@reset')->middleware('guest');
		Route::delete('logout', 'Bageur\Auth\Controllers\AuthController@logout')->middleware('bgr.verify');
		Route::post('refresh', 'Bageur\Auth\Controllers\AuthController@refresh')->middleware('bgr.verify');
		Route::post('dataLogin', 'Bageur\Auth\Controllers\AuthController@dataLogin')->middleware('bgr.verify');
        Route::post('me', 'Bageur\Auth\Controllers\AuthController@me')->middleware('bgr.verify');
        Route::post('deviceregister', 'Bageur\Auth\Controllers\AuthController@device_add');
	});

		Route::group(['prefix' => 'bageur/v1'], function () {
			Route::get('p-upload/group/{folder}/{id}', 'Bageur\Auth\Controllers\PerkakasController@getgroup_p_upload');
			Route::post('p-upload', 'Bageur\Auth\Controllers\PerkakasController@p_upload');
			Route::delete('p-upload/{id}', 'Bageur\Auth\Controllers\PerkakasController@delete_p_upload');

			Route::post('p-upload-blob', 'Bageur\Auth\Controllers\PerkakasController@p_upload_blob');
			
			Route::apiResource('menu', 'Bageur\Auth\Controllers\MenuController')->middleware('bgr.verify');
			Route::apiResource('admin', 'Bageur\Auth\Controllers\UserController')->middleware('bgr.verify');
			Route::apiResource('level', 'Bageur\Auth\Controllers\LevelController')->middleware('bgr.verify');
			Route::apiResource('menu.action', 'Bageur\Auth\Controllers\MenuActionController')->middleware('bgr.verify');
			Route::get('bageur-akses/{id}', 'Bageur\Auth\Controllers\LevelController@bageur_akses')->middleware('bgr.verify');
			Route::post('level-setup/{id}', 'Bageur\Auth\Controllers\LevelController@setup')->middleware('bgr.verify');

			Route::get('menu-showseo/{link}', 'Bageur\Auth\Controllers\MenuController@showseo')->middleware('bgr.verify');
			Route::post('menu-up-urutan', 'Bageur\Auth\Controllers\MenuController@urutankan')->middleware('bgr.verify');
			Route::post('menu/ubahstatus', 'Bageur\Auth\Controllers\MenuController@ubahstatus')->middleware('bgr.verify');
			Route::get('global/menu', 'Bageur\Auth\Controllers\MenuController@menufull');
			Route::get('global/notif', 'Bageur\Auth\Controllers\MenuController@notif');
			Route::get('global/notif/{id}', 'Bageur\Auth\Controllers\MenuController@notif_detail');
			Route::get('getuserinfo/', 'Bageur\Auth\Controllers\AuthController@getuserinfo')->middleware('bgr.verify');
    		Route::put('edit-user/', 'Bageur\Auth\Controllers\AuthController@edituser')->middleware('bgr.verify');
		});

	});

