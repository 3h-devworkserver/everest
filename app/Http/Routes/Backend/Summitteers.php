<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-summitteers-management'
], function() use ($router) {
	/**
	 * Summitteers Management
	 */
	get('summitteers/delete/{id}', 'SummitteersController@deleteSummitteer')->name('admin.summitteers.delete');
   	resource('summitteers', 'SummitteersController', ['except' => ['show']]);
});