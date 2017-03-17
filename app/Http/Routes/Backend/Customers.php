<?php

$router->group([
	'middleware' => 'access.routeNeedsPermission:view-customer-management'
], function() use ($router) {
	
	get('customers', 'CustomerController@index')->name('admin.customers.index');
	post('customers', 'CustomerController@store');
	get('customers/create', 'CustomerController@create')->name('admin.customers.create');
	// get('customers/registered', 'CustomerController@registeredCustomers')->name('admin.customers.registered');
	get('customers/{id}/edit', 'CustomerController@edit')->name('admin.customers.edit');
	patch('customers/{id}', 'CustomerController@update');
	delete('customers/{id}/delete', 'CustomerController@destroy')->name('admin.customers.destroy');

});