<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-customer-management'
], function() use ($router) {
	
	get('customers', 'CustomerController@index')->name('admin.customers.index');
	get('customers/registered', 'CustomerController@registeredCustomers')->name('admin.customers.registered');
	get('customers/{id}/edit', 'CustomerController@edit')->name('admin.customers.edit');
	patch('customers/{id}', 'CustomerController@update');
	delete('customers/{id}/delete', 'CustomerController@destroy')->name('admin.customers.destroy');

});