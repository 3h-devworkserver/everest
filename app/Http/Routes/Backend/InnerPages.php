<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-page-management'
], function() use ($router) {
	/**
	 * Inner Page Management
	 */
	get('static/{id}/delete', 'InnerPageController@deletestaticBlock');
	get('innerpages/{id}', 'InnerPageController@delete')->name('admin.innerpages.destory');
    resource('innerpages', 'InnerPageController', ['except' => ['show']]);
});