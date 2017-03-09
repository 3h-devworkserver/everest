<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-menu-management'
], function() use ($router) {
	/**
	 * Menu Management
	 */
	Route::group(['prefix' => 'menus/{id}', 'where' => ['id' => '[0-9]+']], function () {
			
	});
	post('menus/order', 'MenuController@postIndex');
	post('menus/new', 'MenuController@postNew');
	get('menus/edit/{id}', 'MenuController@Edit');
	post('menus/edit/{id}', 'MenuController@menuEdit');
	post('menus/delete', 'MenuController@menuDelete');
    resource('menus', 'MenuController');
});