<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-purchase-order-management'
], function() use ($router) {
	
	get('purchases', 'PurchaseController@index')->name('admin.purchases.index');
	get('purchases/{id}/summary', 'PurchaseController@summary')->name('admin.purchases.summary');
	
});