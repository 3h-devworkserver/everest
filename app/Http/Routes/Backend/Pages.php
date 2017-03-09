<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-page-management'
], function() use ($router) {
	/**
	 * Page Management
	 */
	Route::group(['prefix' => 'pages/{id}', 'where' => ['id' => '[0-9]+']], function () {
		get('status/{status}', 'PageController@status')
			->name('admin.pages.status')
			->where([
				'status' => '[0,1]'
			]);
			
	});
	get('pages/deactivated', 'PageController@deactivated')->name('backend.pages.deactivated');
	post('pages/blockimage', 'PageController@uploadblockimage')->name('backend.pages.blockimage');
	get('static/{id}/delete', 'PageController@deletestaticBlock');
    resource('pages', 'PageController', ['except' => ['show']]);
});